<?php
namespace Controller;
    require_once('../Model/m_detalle.php');
    require_once('../Model/m_entrega.php');
    require_once('../Model/mensajero.php');
    require_once('../Model/m_listingdetalle.php');
    require_once('../Model/m_listingentrega.php');
    require_once('../Model/m_listingarticulo.php');
    require_once('../Model/m_listingtipoarticulo.php');
    require_once('../Controller/_controller.php');

use Email;
use ListingArticulos;
use ListingDetalles;
use ListingEntregas;
use ListingTipoArticulos;
use Model\db\entity;
use Model\Detalle;
use Model\Entrega;

class DetalleController extends Controller{

        public function __construct(){
            $this->entity = new Detalle();
            $this->viewEntity = new ListingDetalles();
            $this->childEntity = new Entrega();
            $this->viewName = 'v_detalle';
            $this->title = 'Detalle';
            $this->subscribe();
        }
        public function Index(){   
            return $this->RedirectToView(['fv'=>'entrega'],$_COOKIE);
        }
        public function Completar(int $id){
            if($id>0){
                $articulos = $this->viewEntity->ReturnList("idEntrega = {$id}");
                $allowed = count($articulos)>0;
                if($allowed){
                    $this->childEntity->EditFields('terminado','1','',$id);
                    $this->setViewBag();
                    $entrega = new ListingEntregas();
                    $this->viewBag->data = $entrega->setAttribute($entrega->Find($id)[0]);
                    $this->getView('completado', false);
                    $mail = new Email();
                    foreach($articulos as $row){
                        $mail->AlertMail($row->idArticulo);
                    }
                    
                }
            }
            else{
                return $this->Index();
            }
            
        }
        public function RemoveDetalle(array $entidad){
            if(isset($entidad['id'], $entidad['idArticulo'], $entidad['cantidad']))
                $this->entity->RemoveDetalle($entidad['id'], $entidad['idArticulo'], $entidad['cantidad']);
            return $this->Details($entidad['id']);            
        }
    
        public function Details(int $id=0, entity $entidad = null){
            $this->setViewBag();
            $receptor = new ListingEntregas();
            $this->viewBag->receptor = $receptor->setAttribute($receptor->Find($id)[0]);
            if($this->viewBag->receptor->terminado == 1){
                return $this->Index();
            }

            $articulos = new ListingArticulos();
            $tipoarticulo = new ListingTipoArticulos();    
            
            $this->viewBag->data = $this->viewEntity->ReturnList("idEntrega = {$receptor->idEntrega}");
            $this->viewBag->tipoarticulos = $tipoarticulo->ReturnList("tipoArticulo != 'impresora'");
            $this->viewBag->articulos = json_encode($articulos->List("tipoArticulo != 'impresora' and cantidadStock > 0"));
            return $this->getView('details', false);
            
        }
        public function Add(array $entidad)
        {
            if(isset($entidad['idEntrega'], $entidad['idArticulo'], $entidad['cantidad']))
                $this->entity->AddDetalle($entidad['idEntrega'], $entidad['idArticulo'], $entidad['cantidad']);
            $this->Details($entidad['idEntrega']);
        }

        public function RedirectToAction(array $http){
            if(isset($http['accion'])){
                switch($http['accion']){
                    case "Add":
                        $this->Add($http);
                    break;
                    case "Edit":
                        $this->Edit($http);
                    break;
                    case "Completar":
                        try{
                            $id = intval($http['id']);
                            $this->Completar($id);
                        }catch(\Exception $e){$this->Index();} 
                    break;
                    case "Remove":                          
                        $this->RemoveDetalle($http);
                    break;
                    default:
                    return $this->Index();
                                     
                }
                                
            }
            else  if(isset($_GET['id'])){
                try{
                    $id = intval($_GET['id']);
                    $this->Details($id);
                }catch(\Exception $e){$this->Index();} 
            }
            else {
                $this->Index();
            }
            
        }
  
    }
    $obj = new DetalleController();
    $obj->RedirectToAction($_REQUEST);  
   
?>