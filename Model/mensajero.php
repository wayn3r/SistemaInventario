<?php
use Model\Correo;
use Model\Perfil;

class Email{
        public $to;
        public $title;
        public $mensaje;
        public $nombrePdf;
        public $pdf;
        public $cabeceras;

        public function SendPdf(string $to,string $title,string $mensaje, string $nombrePdf, $pdf, string $replyto_hidden = null){

            //adecuando las variables para enviarlas por correo
            $this->SetPdf($to,$title,$mensaje,$nombrePdf,$pdf,$replyto_hidden);
            $this->SendMessage();
        }
        public function SetPdf(string $to,string $title,string $mensaje, string $nombrePdf, $pdf,string $replyto_hidden = null){
                //cabecera del email 
                $headers = "From: Sistema de Inventario Ron Barceló <default@email>\r\n";
                // $headers .= "Reply-To: " . $replyto . "\r\n";
                if($replyto_hidden != null)
                    $headers .= "Bcc: " . $replyto_hidden . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: multipart/mixed; boundary=\"=B=A=R=C=E=L=O=\"\r\n\r\n";
                
                
                //armando mensaje del email
                $message = "--=B=A=R=C=E=L=O=\r\n";
                $message .= "Content-type:text/plain; charset=utf-8\r\n";
                $message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $message .= "{$mensaje} \r\n\r\n";
                $message .= "La información contenida en este mensaje de correo electrónico, incluidos los documentos o archivos adjuntos, está destinada solo para el uso personal y confidencial de los destinatarios mencionados anteriormente. Si ha recibido esta comunicación por error, avísenos de inmediato por correo electrónico para tomar las medidas necesarias.\r\n\r\n";
                
                //archivo adjunto  para email    
                $message .= "--=B=A=R=C=E=L=O=\r\n";
                $message .= "Content-Type: application/octet-stream; name=\"" . $nombrePdf . ".pdf\"\r\n";
                $message .= "Content-Transfer-Encoding: base64\r\n";
                $message .= "Content-Disposition: attachment; filename=\"" . $nombrePdf . ".pdf\"\r\n\r\n";
                $message .= base64_encode($pdf) . "\r\n\r\n";
                $message .= "--=B=A=R=C=E=L=O=--";
            
                $this->to = $to;
                $this->title = $title;
                $this->mensaje = $message;
                $this->nombrePdf = $nombrePdf;
                $this->pdf = $pdf;
                $this->cabeceras = $headers;
        }
        public function SendMessage(){
            mail($this->to,$this->title,$this->mensaje,$this->cabeceras);
        }
        public function SetMessage(string $to, string $title, string $mensaje,string $replyto_hidden = null){
            //cabecera del email 
            $headers = "From: Sistema de Inventario Ron Barceló <default@email>\r\n";
            // $header .= "Reply-To: " . $replyto . "\r\n";
            if($replyto_hidden != null)
                    $headers .= "Bcc: " . $replyto_hidden . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8;\r\n\r\n";

            //armando mensaje
            $message = "{$mensaje} \r\n\r\n";
            $message .= "<p>La información contenida en este mensaje de correo electrónico, incluidos los documentos o archivos adjuntos, está destinada solo para el uso personal y confidencial de los destinatarios mencionados anteriormente. Si ha recibido esta comunicación por error, avísenos de inmediato por correo electrónico para tomar las medidas necesarias.</p>\r\n\r\n";

            $this->to = $to;
            $this->title = $title;
            $this->mensaje = $message;
            $this->cabeceras = $headers;

        }
        public function GetMails(int $idPerfil = 0){

            require_once('../Model/m_correo.php');
            $sendto = '';
            if($idPerfil>0){
                require_once('../Model/m_perfil.php');
                //buscando el correo del usuario   
                $perfil = new Perfil();
                $perfil = $perfil->Find($idPerfil)[0];
                $sendto = $perfil['correo'].',';
            }
            
            //obteniendo correos a reenviar
            $correos = new Correo();
            $correos = $correos->ReturnList();
            foreach($correos as $row){
                $sendto .= $row->correo.',';
            }
            $sendto = trim($sendto,',');
            return $sendto;
        }
        public function AlertMail(int $idArticulo = 0){
                $articulos = new ListingArticulos();
                if($idArticulo > 0){
                    $articulos = $articulos->Find($idArticulo);
                }else{
                    $articulos = $articulos->List("tipoArticulo not like 'impresora%'");
                }
                foreach($articulos as $row){
                    if($row['cantidadContada'] > 0 && $row['cantidadStock'] < $row['cantidadContada'] / 3){
                    //enviando correo de alerta de poco inventario
                    $mail = new Email();
                    //buscando correos
                    $sendto = $mail->GetMails();
                    $nombre = strtolower($row['tipoArticulo']);
                    $mensaje =<<<input
                        <h1>Queda poco stock de este articulo: {$row['tipoArticulo']} {$row['marca']} {$row['modelo']}</h1>
                        <p>Solo queda una cantidad de {$row['cantidadStock']} {$nombre}(s) en stock, de un total de {$row['cantidadContada']} contado.</p>
                        <hr/>
                        <p><strong>Categoria: </strong>{$row['categoria']}</p>
                        <p><strong>Tipo de articulo: </strong>{$row['tipoArticulo']}</p>
                        <p><strong>Marca: </strong>{$row['marca']}</p>
                        <p><strong>Modelo: </strong>{$row['modelo']}</p>
                        <p><strong>Cantidad contada: </strong>{$row['cantidadContada']}</p>
                        <p><strong>Cantidad en stock: </strong>{$row['cantidadStock']}</p>
                        <p><strong>Fecha de compra: </strong>{$row['fechaCompra']}</p>
                        <p><strong>Fecha de inventario: </strong>{$row['fechaInventario']}</p>
                    input;
                    
                    $mail->SetMessage('noreplay@ronbarcelo',"Poco {$nombre} en stock",$mensaje,$sendto);
                    $mail->SendMessage();
                    }
                }   
        }
    }
?>