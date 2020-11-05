<?php

use Controller\Controller;
use Controller\ReporteController;
use filter\session;
use Model\Correo;
use Model\Entrega;
use Model\Perfil;
use Mpdf\Mpdf;

require_once('../lib/mpdf/vendor/autoload.php');
require_once('../Controller/_controller.php');
require_once('../Model/m_entrega.php');
require_once('../Model/m_listingentrega.php');
require_once('../Model/m_listingdetalle.php');
require_once('../Model/m_perfil.php');
require_once('../Model/m_correo.php');
require_once('../Model/mensajero.php');
require_once('../filters/sesion.php');


class PdfController extends Controller{
    public function __construct(){
        $this->entity = new Entrega();
        $this->viewEntity = new ListingEntregas();
        $this->childEntity = new ListingDetalles;
        $this->viewName = 'v_';
        $this->title = 'Reporte';
        $this->sesion = session::GetSession();
    }

	public function GenerarPDF(string $html,string $name){
        // Instanciamos un objeto de la clase MPDF.
        $mpdf = new mPDF();
        $css = file_get_contents('../utils/css/reporte.css');
        $mpdf->WriteHTML($css,1);
        $mpdf->WriteHTML($html,2);
        $mpdf->SetTitle('Ron Barceló - Reporte');
        $mpdf->Output($name.'.pdf','I');
        return $mpdf->Output($name.'.pdf','S');
        
	}

	public function GetEntregaHTML(int $id){        
            
        $html = $this->RenderEntrega($id);
        return $html;
    }
	public function GetReporteHTML(array $data){        
        if(isset($data['tipo']) && isset($data['filtro'])){
            $html = $this->RenderReporte($data);
            return $html;
        }
        return '';
    }
    public function Reporte($http){
        if(isset($http['filtro']) && isset($http['tipo'])){
            
            $html = $this->GetReporteHTML($http);
            if($html == ''){
                echo "ERROR - Los datos proporcionados no son validos"; exit;
            }
            $pdf = $this->GenerarPDF($html,$http['tipo'].'-reporte');
            if(isset($http['mail']) && $http['mail'] == 'on'){
                //enviando el mensaje
                $email = new Email();
                //buscando el correo del usuario
                $user = $this->sesion->GetUser();
                $sendto = $email->GetMails($user->idPerfil);

                //fecha
                require_once('../Model/functions.php');
                $mes = getMonth($http['mes']);
                $year = explode('-',$http['mes'])[0];
                $year = explode('/',$year)[0];

                
                $email->SendPdf('noreplay@ronbarcelo','Reporte de '.$http['filtro'].'s','Reporte de '.$http['filtro'].'s'.' del mes de '.$mes.' de '.$year,'reporte-'.$http['filtro'].'-'.$mes.'-'.$year,$pdf,$sendto);
            }
        }
        else{
            echo "ERROR - Los datos proporcionados no son validos"; exit;
        }
    }

    public function RenderEntrega(int $id){
        $this->setViewBag();
		$this->viewBag->data[0] = $this->viewEntity->setAttribute($this->viewEntity->Find($id)[0]);
		if(isset($this->viewBag->data[0]->idEntrega)){
            $this->viewBag->children = $this->getChildrenData($id);
            $tbody='';
            if(count($this->viewBag->children) > 0){
                foreach($this->viewBag->children as $row){
                    $tbody.='
                    <tr scope="row ">
                        <td scope="col">'.$row->tipoArticulo.'</td>
                        <td scope="col">'.$row->modelo.'</td>
                        <td scope="col">'.$row->cantidad.'</td>
                    </tr>';
                }
            }
            else{
                $tbody = '
                <tr scope="row ">
                    <td scope="col" colspan="3">No existen registros</td>
                </tr>';
            }
            $html=<<<input
            <html>
            <head>
            </head>
            <body>
            <div class="p-5 border rounded col-11 col-sm-10 col-lg-8 m-auto" id="reporte">
                <div class="row justify-content-between mb-5">
                <table class="table">
                    <tbody class="between">
                        <tr scope="row" >
                            <td colspan="21"><h2>Ron Barceló</h2><td>
                        </tr>
                        <tr scope="row" class="border-bottom">
                            <th colspan="1"><span for="entrega" class="">#</span></th>
                            <td colspan="1" class="text-center">
                            <span   id="entrega" class="pl-3 pr-3">{$this->viewBag->data[0]->idEntrega}</span>
                            </td>
                            <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                            <th colspan="3">
                                <span for="fecha" class="col-12 col-md-7">Fecha de Entrega:</span>
                            </th>
                            <td colspan="7" class="text-center">
                                <span id="fecha" class="pl-5 pr-5 col-12 col-md-5">{$this->viewBag->data[0]->fechaEntrega}</span>
                            </td>
                        </tr>
                        <tr>
                        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <tbody>
                        <tr>
            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                        </tr>
                        <tr scope="row" class="border-bottom">
                            <th scope="col" colspan="1">Localidad:</th>
                            <td scope="col" colspan="10" >{$this->viewBag->data[0]->localidad}</td>
                        </tr>
                        <tr scope="row" class="border-bottom">
                            <th scope="col" colspan="1">Para:</th>
                            <td scope="col" colspan="20" >{$this->viewBag->data[0]->departamento} / {$this->viewBag->data[0]->codigoEmpleado}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="table-responsive mb-4 mt-4">   
                <table class="table border rounded">
                    <thead class="bg-light">
                        <tr scope="row">
                            <th scope="col">Articulo</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody class="border-bottom">
                        {$tbody}
                    </tbody>
                    <tfoot class="bg-light">
                        <tr scope="row">
                            <td scope="col" colspan="2" class="text-right font-weight-bold">Total de articulos:</td>
                            <td scope="col">{$this->viewBag->data[0]->totalArticulos}</td>
                        </tr>
                    </tfoot>
                </table>
                </div>
                <table class="table between">
                    <tbody class="between">
                    <tr scope="row" class="border-bottom">
                        <td scope="col" class="font-weight-bold text-center ">
                            {$this->viewBag->data[0]->recibidoPor}
                        </td>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <td scope="col" class="font-weight-bold text-center">
                            {$this->viewBag->data[0]->entregadoPor}
                        </td>
                    </tr>
                    <tr scope="row">
                    </tr>
                        <td scope="col" class="text-muted text-center">
                            Recibido por
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td scope="col" class="align-top text-muted text-center">
                            Entregado por
                        </td>
                    </tbody>
                </table>
            </div>
            </body>
            </html>
            input;
            return $html;
        }
        return false;
    }

    public function Entrega(array $http){
        if(isset($http['idReporte']) && is_numeric($http['idReporte']) && $http['idReporte'] > 0){
            $html = $this->GetEntregaHTML($http['idReporte']);
            $pdf = $this->GenerarPDF($html,'entrega-'.$http['idReporte']);
            if(isset($http['mail']) && $http['mail'] == 'on'){
                //enviando el mensaje
                $email = new Email();
                //buscando el correo del usuario
                $entrega = $this->entity->Find($http['idReporte'])[0];
                $sendto = $email->GetMails($entrega['idPerfil']);
                
                $email->SendPdf('noreplay@ronbarcelo','Reporte de entrega','Reporte de entrega #'.$http['idReporte'],'entrega-'.$http['idReporte'],$pdf,$sendto);
            }
        }
        else{
            echo "ERROR - numero de entrega no valido"; exit;
        }
    }

   
    public function RenderReporte(array $http){

        if(isset($http['filtro']) && isset($http['tipo'])){
            try{
                    //cambiando el accion para poder usar el controller
                    $_REQUEST['accion'] .= 'Pdf';
                    require_once('../Controller/reporte.php');
                    
                $reportc = new ReporteController();
                $reportc->SetReportData($http);
                $this->viewBag = $reportc->viewBag;
                $tbody = '';
                $thead = '';
                switch($this->viewBag->titulo){
                    case 'articulos':
                        $thead =<<<input
                            <th scope="col">Fecha Inventario</th>
                            <th scope="col">Fecha Compra</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Articulo</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Contado</th>
                            <th scope="col">Stock</th>
                        input;
                        if(count($this->viewBag->data)>0){
                            foreach($this->viewBag->data as $row){
                            $tbody .=<<<input
                                <tr scope="row">
                                        <td scope="col">{$row->fechaInventario}</td>
                                        <td scope="col">{$row->fechaCompra}</td>
                                        <td scope="col">{$row->categoria}</td>
                                        <td scope="col">{$row->tipoArticulo}</td>
                                        <td scope="col">{$row->modelo}</td>
                                        <td scope="col">{$row->cantidadContada}</td>
                                        <td scope="col">{$row->cantidadStock}</td>
                                    </tr>
                                input;
                            }
                        }
                        else{
                            $tbody =<<<input
                            <tr scope="row">
                            <td scope="col" colspan="7"  class="text-center text-muted uppercase">No existen articulos para el filtro seleccionado</td>
                            </tr>
                            input;                           
                        }
                    break;
                    case 'entregas':
                        $thead =<<<input
                            <th scope="col">#</th>
                            <th scope="col">Fecha Entrega</th>
                            <th scope="col">Recibido por</th>
                            <th scope="col">Codigo de empleado</th>
                            <th scope="col">Entregado por</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Total articulos entregados</th>
                        input;
                        if(count($this->viewBag->data) > 0){
                            foreach($this->viewBag->data as $row){
                                $row->terminado = ($row->terminado == '1')?'Completada':'Pendiente';
                                $tbody .=<<<input
                                <tr scope="row">
                                    <td scope="col">{$row->idEntrega}</td>
                                    <td scope="col">{$row->fechaEntrega}</td>
                                    <td scope="col">{$row->recibidoPor}</td>
                                    <td scope="col">{$row->codigoEmpleado}</td>
                                    <td scope="col">{$row->entregadoPor}</td>
                                    <td scope="col">{$row->departamento}</td>
                                    <td scope="col">{$row->terminado}</td>
                                    <td scope="col">{$row->totalArticulos}</td>
                                    </tr>
                                input;
                            }
                        }
                        else{
                            $tbody =<<<input
                            <tr scope="row" >
                                <td scope="col" colspan="8" class="text-center text-muted uppercase">No existen entregas para el filtro seleccionado</td>
                            </tr>
                            input;
                        }
                    break; 
                    case 'impresoras':
                        $thead =<<<input
                            <th scope="col">Fecha Inventario</th>
                            <th scope="col">Fecha compra</th>
                            <th scope="col">Número de serie</th>
                            <th scope="col">Dirección IP</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Estado</th>
                        input;
                        if(count($this->viewBag->data) > 0){
                            foreach($this->viewBag->data as $row){
                                $row->terminado = ($row->terminado == '1')?'Completada':'Pendiente';
                                $tbody .=<<<input
                                <tr scope="row">
                                    <td scope="col">{$row->fechaInventario}</td>
                                    <td scope="col">{$row->fechaCompra}</td>
                                    <td scope="col">{$row->serialNumber}</td>
                                    <td scope="col">{$row->direccionIp}</td>
                                    <td scope="col">{$row->modelo}</td>
                                    <td scope="col">{$row->marca}</td>
                                    <td scope="col">{$row->estado}</td>
                                </tr>
                                input;
                            }
                        }
                        else{
                            $tbody =<<<input
                            <tr scope="row" >
                                <td scope="col" colspan="8" class="text-center text-muted uppercase">No existen impresoras para el filtro seleccionado</td>
                            </tr>
                            input;
                        }
                    break; 
                }
                $Mes = ucfirst($this->viewBag->mes).', '.$this->viewBag->year;
                $date = date('Y-m-d');
                $html = <<<input
                <html>
                <head>
                </head>
                <body>
                <div class="p-5 border rounded col-11 col-sm-10 col-lg-8 m-auto" id="reporte">
                    <div class="row justify-content-between mb-5">
                    <table class="table">
                        <tbody class="between">
                            <tr scope="row" >
                                <td colspan="21"><h2>Ron Barceló</h2><td>
                            </tr>
                            <tr scope="row" class="border-bottom">
                                <th colspan="1"><span for="entrega" class="">Reporte:</span></th>
                                <td colspan="8" class="text-center">
                                <span  id="entrega" class="pl-3 pr-3 ">{$Mes}</span>
                                </td>
                                <th></th><th></th>
                                <th colspan="3" >
                                    <span for="fecha" class="col-12 col-md-7">Fecha:</span>
                                </th>
                                <td colspan="7" class="text-center">
                                    <span id="fecha" class="pl-5 pr-5 col-12 col-md-5">{$date}</span>
                                </td>
                            </tr>
                            <tr>
                            <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                            <tr>
                <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
                            </tr>
                            <tr scope="row" class="border-bottom">
                                <th scope="col" colspan="1">Reporte por:</th>
                                <td scope="col" colspan="20" >{$this->viewBag->cuser['nombre']} {$this->viewBag->cuser['apellido']}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-responsive mb-4 mt-4">   
                    <table class="table border rounded">
                        <thead class="bg-light">
                            <tr scope="row">
                                {$thead}
                            </tr>
                        </thead>
                        <tbody class="border-bottom">
                            {$tbody}
                        </tbody>
                        <tfoot class="bg-light">
                            <tr scope="row">
                                <td scope="col" colspan="7" class="text-muted border-top-0">{$this->viewBag->mensaje}</td>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
                </body>
                </html>
                input;
            }catch(\Exception $e){$html = '';}
            return $html;
        }
        else{
            echo 'Establezca un filtro y un mes'; exit;
        }
    }

    public function RedirectToAction(array $http)
    {
        if(isset($http['accion']))
        {
            switch($http['accion']){
                case 'Entrega':
                    $this->Entrega($http);
                break;
                case 'Reporte':
                    $this->Reporte($http);
                break;
            }
        }
        else{
            $this->RedirectToView(['fv'=>'home'],[]);
        }
    }
}

///////////////////////////////////////////////////
$obj = new PdfController();
$obj->RedirectToAction($_REQUEST);

