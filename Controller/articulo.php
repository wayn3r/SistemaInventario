<?php
    namespace Controller;
    require_once('../Model/m_listingarticulo.php');
    require_once('../Model/m_articulo.php');
    require_once('../Model/m_tipoarticulo.php');
    require_once('../Model/m_marca.php');
    require_once('../Model/m_estado.php');
    require_once('../filters/sesion.php');
    require_once('../Model/m_perfil.php');
    require_once('../Model/m_listingexistencia.php');
    require_once('../Model/mensajero.php');
    require_once('../Controller/_controller.php');

use Email;
use filter\session;
use ListingArticulos;
use ListingExistencias;
use Model\Articulo;
use Model\db\entity;
use Model\Estado;
use Model\Marca;
use Model\Perfil;
use Model\TipoArticulo;
use Mpdf\Tag\Em;

class ArticuloController extends Controller{

        public function __construct(){
            $this->entity = new Articulo();
            $this->viewEntity = new ListingArticulos();
            $this->childEntity = new ListingExistencias();
            $this->viewName = 'v_articulo';
            $this->title = 'Modelos';
            $this->sesion = session::GetSession();
            $this->subscribe();
        }

        public function Index(){
            $this->setViewBag(); //creando variable viewBag
            //devolviendo tipos de articulos para details y categorias para index
            $marcas = new Marca();
            $tipos = new TipoArticulo();
            $listM = $marcas->ReturnList(); //obteniendo lista de marcas
            $listT = $tipos->ReturnList(); //obteniendo lista de tipos de articulo

            $this->viewBag->marcas = $listM;
            $this->viewBag->tipos = $listT;
            $this->getData();//obteniendo datos de las vista
            $this->getView('index',true);//devoliendo la vista
        }
        public function Edit(array $entidad){
                
            $this->entity->setAttribute($entidad);
            $this->entity->Edit($this->entity);
            $this->Index();
            $mail = new Email();
            $mail->AlertMail($entidad['idArticulo']);
        }
        
        public function Details(int $id = 0, entity $entidad = null)
        {
            $this->setViewBag();
            $estados = new Estado();
            $list = $estados->ReturnList();
            $this->viewBag->estados = $list;
            if(!$this->getData($id,$entidad)){
                return $this->Index();
            }            
            return $this->getView('details', true);
        }
        public function Remove(int $id){
            $articulo = $this->viewEntity->Find($id);
            if(count($articulo)>0){
                $this->entity->Remove($id);  
                $this->Index();
                
                //mail ---------------------
                $titulo = ($this->result->info->errno == 1451)?'intentado eliminar':'eliminado';
                //obteniendo informacion del usuario responsable
                $perfil = new Perfil();
                $user = $this->sesion->GetUser();
                $perfil = $perfil->Find($user->idPerfil)[0];
                //obteniendo articulo 
                $articulo = $articulo[0];
                //enviando correo de alerta de eliminacion de articulo
                $mail = new Email();
                //buscando correos
                $sendto = $mail->GetMails();
                $mensaje =<<<input
                    <h1>Eliminación de articulo</h1>
                    <p><strong>Nombre de usuario: </strong>{$user->user}</p>
                    <p>{$perfil['nombre']} {$perfil['apellido']}, ha {$titulo} un articulo del inventario.</p>
                    <hr/>
                    <p><strong>Categoria: </strong>{$articulo['categoria']}</p>
                    <p><strong>Tipo de articulo: </strong>{$articulo['tipoArticulo']}</p>
                    <p><strong>Marca: </strong>{$articulo['marca']}</p>
                    <p><strong>Modelo: </strong>{$articulo['modelo']}</p>
                    <p><strong>Cantidad contada: </strong>{$articulo['cantidadContada']}</p>
                    <p><strong>Cantidad en stock: </strong>{$articulo['cantidadStock']}</p>
                    <p><strong>Fecha de compra: </strong>{$articulo['fechaCompra']}</p>
                    <p><strong>Fecha de inventario: </strong>{$articulo['fechaInventario']}</p>
                input;
                
                $mail->SetMessage('noreplay@ronbarcelo','Articulo eliminado',$mensaje,$sendto);
                $mail->SendMessage();
            }else{
               return $this->Index();
            }

        }
       

    }
    $obj = new ArticuloController();
    $obj->RedirectToAction($_REQUEST);  
   
?>