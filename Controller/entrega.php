<?php
    namespace Controller;
    require_once('../Model/m_entrega.php');
    require_once('../Model/m_empleado.php');
    require_once('../Model/m_listingarticulo.php');
    require_once('../Model/m_listingentrega.php');
    require_once('../Model/m_listingdetalle.php');
    require_once('../Model/m_listingtipoarticulo.php');
    require_once('../Controller/_controller.php');

use filter\session;
use ListingDetalles;
use ListingEntregas;
use Model\db\entity;
use Model\Departamento;
use Model\Empleado;
use Model\Entrega;
    
    class EntregaController extends Controller{

        public function __construct(){
            $this->entity = new Entrega();
            $this->viewEntity = new ListingEntregas();
            $this->childEntity = new ListingDetalles();
            $this->viewName = 'v_entrega';
            $this->title = 'Entrega';
            $this->sesion=session::GetSession();
            $this->subscribe();
        }

        public function Index(){           
            $this->setViewBag();
            $this->getData();
            $this->getView('index', false);        
        }
        public function Details(int $id=0, entity $entidad = null){         
            $this->setViewBag();
            if(!$this->getData($id)){
                return $this->Index();
            }
            return $this->getView('details', false);
        }
        public function Add(array $entidad){

            $empleado = new Empleado();
            $empleado = $empleado->FindByField('codigoEmpleado',$entidad['codigoEmpleado']);
            if(count($empleado) < 1){
                return $this->Entrega(0,$entidad);
            }
            
            $this->entity->setAttribute($entidad);
            $user = $this->sesion->GetUser();
            $this->entity->idPerfil = $user->idPerfil;
            $this->entity->idEmpleado = $empleado[0]['idEmpleado'];
            $this->entity->Add($this->entity);
            $id = $this->entity->GetLastId();
            return $this->RedirectToView(['fv'=>'detalle','id'=>$id],$_COOKIE);
        }

        public function Edit(array $entidad){   

            $this->entity->setAttribute($entidad);
            $this->entity->Edit($this->entity);
            return $this->RedirectToView(['fv'=>'detalle','id'=>$entidad['idEntrega']],$_COOKIE);
        }
        public function Entrega(int $id = 0, array $data = null){
            $this->setViewBag();
            $empleado = new Empleado();
            $this->viewBag->empleados = $empleado->ReturnList();

            if(isset($data)){
                $this->viewBag->data = $this->viewEntity->setAttribute($data);
                $this->viewBag->error = isset($entidad['error'])?$entidad['error']:null;
            }
            else if($id>0){
                $this->viewBag->data = $this->viewEntity->setAttribute($this->viewEntity->Find($id)[0]);
            }
           
            $this->getView('entrega', false);     
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
                    case "Entrega":
                        try{
                            $id=0;
                            if(isset($http['id']))
                                $id = intval($http['id']);
                            $this->Entrega($id);
                        }catch(\Exception $e){$this->Entrega();}  
                    break;
                    case "Remove":
                        try{
                            $id = intval($http['id']);
                            $this->Remove($id);
                        }catch(\Exception $e){$this->Index();}      
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
    $obj = new EntregaController();
    if(!isset($_REQUEST['idReporte']))
        $obj->RedirectToAction($_REQUEST);  
   
?>