<?php
    namespace Controller;
    require_once('../Model/db/db_entity.php');
    require_once('../Model/m_notificacion.php');
    require_once('../Observer/interfaces.php');
    require_once('../filters/sesion.php');
    require_once('../filters/filter.php');
 
use filter\Filter;
use Model\db\entity;
use Model\Notificacion;
use Observer\iSubscriber;
use stdClass;

//asegurando que tenga el usuario tenga permisos
$filter = new Filter;
$filter->Filtrar();
 
abstract class Controller implements iSubscriber{
        protected $viewName;
        protected $entity;
        protected $viewEntity;
        protected $childEntity;
        public $viewBag;
        public $title;  
        public $result;
        public $sesion;
        
        public function Index(){
            $this->setViewBag();
            $this->getData();
            $this->getView('index', true);
            
        }
        
        public function Details(int $id=0, entity $entidad = null){
            $this->setViewBag();
            if(!$this->getData($id,$entidad)){
                // $this->update();
                return $this->Index();
            }
            return $this->getView('details', true);
            
        }
        

        public function getData(int $id=0, entity $entidad = null){
            $data = []; 
            $children = [];
            $result = true;
            if($id > 0 || $entidad != null){
                $registros = $this->viewEntity->Find($id,$entidad);
                $children = $this->getChildrenData($id,$this->childEntity);
            }
            if(!isset($registros[0])){
                $registros = $this->viewEntity->List();
                $result = false;
            }               
            foreach($registros as $dato){
                $this->viewEntity->setAttribute($dato);
                $data[] =  $this->viewEntity->getClone();               
            }
            $this->setViewBag();
            $this->viewBag->data = $data;
            $this->viewBag->children = $children;
            return $result;
        }
        public function getChildrenData(int $id,entity $entidad = null){
            if($id > 0 || $entidad != null){
                $children = [];
                if($this->childEntity != null){
                    $children = $this->viewEntity->getChildren($id,$this->childEntity);
                }
                return $children;                
            }

        }

        public function setViewBag(){
            if($this->viewBag == null)
                $this->viewBag = new stdClass();
        }
        public function getView(string $page, bool $sidebar = false, bool $notificacion=true){
           
            $this->RedirectToView($_GET, $_COOKIE);
            $this->GetNavData($page, $sidebar, $notificacion);
        }
        public function GetNavData(string $page, bool $sidebar = true, bool $notificacion=true){
            // devolviendo datos de notificaciones y sidebar a la vista
            $this->setViewBag();
            if($notificacion){
                $notificacion = new Notificacion();
                $this->viewBag->notificaciones = $notificacion->ReturnList(null,'fecha',true);         
            }
            
            require_once("../View/Shared/head.php");

            if($sidebar){
                $this->viewBag->sideBar = $this->entity->getSideBarData(true,true);
                require_once("../View/Shared/sidebar.php");
            }
            require_once("../View/{$this->viewName}/{$page}.php");
            require_once("../View/Shared/foot.php");
            
        }

        public function RedirectToView(array $get, array $coockie){
            // verificando redireccionamiento y enviando datos de toast de ser necesaria
            if(isset($get['fv'])){
                if(isset($this->result->info))
                    setcookie('info', serialize($this->result->info), time() + (4), "/");
                header("location:../Controller/{$get['fv']}.php".(isset($get['id'])?'?id='.$get['id']:''));
            }
            else if(isset($coockie['info'])){
                $this->update(unserialize($coockie['info']));
                setcookie('info',null,-1,'/');
            }
        }
        public function Add(array $entidad){
            
            $this->entity->setAttribute($entidad);
            $this->entity->Add($this->entity);
            $this->Index();
        }

        public function Edit(array $entidad){
                
                $this->entity->setAttribute($entidad);
                $this->entity->Edit($this->entity);
                $this->Index();
            
        }
        public function Remove(int $id){
            $this->entity->Remove($id);
            $this->Index();            
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
                    case "Remove":
                        try{
                            $id = intval($http['id']);
                            $this->Remove($id);
                        }catch(\Exception $e){}      
                    break;
                    default:
                    return $this->Index();                                     
                }
                                
            }
            else  if(isset($_GET['id']) && is_numeric($_GET['id'])){
                $this->Details($_GET['id']);
            }
            else {
                $this->Index();
            }
            
        }
  

    public function update($info)
    {
        
        $this->result = new stdClass;
        $this->result->info = $info;
        if($info->entidad == 'entregas'){
            $info->rows = round($info->rows/3,0);
            if($info->rows == 1)
                $info->entidad = 'entrega';
        }

        if($info->error == ''){
            $this->result->color = 'success';
            $this->result->mensaje = "Se ha {$info->evento} {$info->rows} {$info->entidad} correctamente";
        }
        else if(substr($info->error,0,9) == 'Duplicate'){
            $this->result->color = 'warning';
            $this->result->mensaje = 'Este registro ya existe, y se ha intentado replicar';
        }
        else if($info->errno == 1451 && (trim($info->entidad) == 'existencia' || trim($info->entidad) == 'articulo')){
            $this->result->color = 'warning';
            $this->result->mensaje = 'Este articulo esta siendo usado en una o varias entregas, y no puede ser removido.';
        }
        else if($info->errno == 1451 && (trim($info->entidad) == 'rol' || trim($info->entidad) == 'rol_acceso')){
            $this->result->color = 'warning';
            $this->result->mensaje = 'Este rol esta siendo usado por uno o varios usuarios, y no puede ser removido.';
        }
        else if($info->error != ''){
            $this->result->color = 'danger';
            $this->result->mensaje = "Ha ocurrido un error al intentar ejecutar esta consulta";
        }
        

    }

    protected function subscribe(){
        $this->entity->addSubscriber($this);
    }
}  

?>