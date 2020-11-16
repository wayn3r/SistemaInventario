<?php
    namespace Controller;
    require_once('../Model/m_impresora.php');
    require_once('../Model/m_listingtoner.php');
    require_once('../Model/m_listingimpresora.php');
    require_once('../Model/m_estado.php');
    require_once('../Model/m_marca.php');
    require_once('../Model/m_articulo.php');
    require_once('../filters/sesion.php');
    require_once('../Model/m_perfil.php');
    require_once('../Model/m_listingarticulo.php');
    require_once('../Model/m_tipoarticulo.php');
    require_once('../Model/m_listingtipoarticulo.php');
    require_once('../Model/mensajero.php');
    require_once('../Controller/_controller.php');

use Email;
use filter\session;
use ListingArticulos;
use ListingImpresoras;
use ListingTipoArticulos;
use ListingToners;
use Model\Articulo;
use Model\Correo;
use Model\db\entity;
use Model\Impresora;
use Model\Estado;
use Model\Perfil;
use Model\TipoArticulo;


class ImpresoraController extends Controller{

        public function __construct(){
            $this->entity = new Impresora();
            $this->viewEntity = new ListingImpresoras();
            $this->viewName = 'v_impresora';
            $this->title = 'Impresoras';
            $this->sesion = session::GetSession();
            $this->subscribe();
        }

        public function Index(){
            $this->setViewBag(); //creando variable viewBag
            $this->getData();//obteniendo datos de las vista
            //devolviendo tipos de articulos para details y categorias para index
            $estados = new Estado();
            $listE = $estados->ReturnList(); //obteniendo lista de estados
            $listA = [];
            
            $articulos = new Articulo();
            $idImpresora = new TipoArticulo();
            $idImpresora = $idImpresora->ReturnList("tipoArticulo like 'impresora%'");
            if(isset($idImpresora[0]) && $idImpresora[0] != null){
                $idImpresora = $idImpresora[0]->idTipoArticulo;
                $listA = $articulos->ReturnList("idTipoArticulo = {$idImpresora}");//obteniendo lista de tipo de impresoras 
            }

            $this->viewBag->estados = $listE;
            $this->viewBag->articulos = $listA;
            $this->getView('index',true);//devolviendo la vista
        }
        public function Details(int $id = 0, entity $entidad = null)
        {
            $this->setViewBag();
            $estados = new Estado();
            $this->viewBag->estados = $estados->ReturnList();

            $toners = new ListingArticulos();
            $this->viewBag->toners = $toners->ReturnList("tipoArticulo like 'toner%' or categoria like 'toner%'");//obteniendo lista de toners

            if($this->getData($id,$entidad)){
                $categoria = new ListingTipoArticulos();
                $categoria = $categoria->Find($this->viewBag->data[0]->idTipoArticulo);//obteniendo categorias para la navegacion
                $this->viewBag->categorias = $categoria;

                $toners = new ListingToners();
                //obteniendo lista de toners 
                $this->viewBag->data[0]->toners = $toners->ReturnList("idImpresora = {$this->viewBag->data[0]->idArticulo}");

                return $this->getView("details", true);
            }
            return $this->Index();
        }
        public function Remove(int $id){
            $impresora = $this->viewEntity->Find($id);
            if(count($impresora)>0){
                $this->entity->Remove($id);
                $this->Index();

                //mail --------------------------
                $titulo = ($this->result->info->errno == 1451)?'intentado eliminar':'eliminado';
                //obteniendo informacion del usuario responsable
                $perfil = new Perfil();
                $user = $this->sesion->GetUser();
                $perfil = $perfil->Find($user->idPerfil)[0];
                //obteniendo impresora 
                $impresora = $impresora[0];
                //enviando correo de alerta de eliminacion de impresora
                $mail = new Email();
                //buscando correos
                $sendto = $mail->GetMails();
                $mensaje =<<<input
                    <h1>Eliminación de impresora</h1>
                    <p><strong>Nombre de usuario: </strong>{$user->user}</p>
                    <p>{$perfil['nombre']} {$perfil['apellido']}, ha {$titulo} una impresora del inventario.</p>
                    <hr/>
                    <p><strong>Número de serie: </strong>{$impresora['serialNumber']}</p>
                    <p><strong>Dirección IP: </strong>{$impresora['direccionIp']}</p>
                    <p><strong>Marca: </strong>{$impresora['marca']}</p>
                    <p><strong>Modelo: </strong>{$impresora['modelo']}</p>
                    <p><strong>Estado: </strong>{$impresora['estado']}</p>
                    <p><strong>Fecha de compra: </strong>{$impresora['fechaCompra']}</p>
                    <p><strong>Fecha de inventario: </strong>{$impresora['fechaInventario']}</p>
                input;
                
                $mail->SetMessage('noreplay@ronbarcelo','Impresora eliminada',$mensaje,$sendto);
                $mail->SendMessage();
            }else{
                $this->Index();
            }
        }
    }
    
    $obj = new ImpresoraController();
    $obj->RedirectToAction($_REQUEST);
       
    

   
?>