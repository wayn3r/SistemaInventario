<?php
    namespace Controller;
    require_once('../Model/m_rol.php');
    require_once('../Model/m_acceso.php');
    require_once('../Model/m_rol_acceso.php');
    require_once('../Model/m_listingacceso.php');
    require_once('../Controller/_controller.php');

use Model\Acceso;
use Model\Rol;
use Model\db\entity;
use Model\ListingAcceso;

class RolController extends Controller{

        public function __construct(){
            $this->entity = new Rol();
            $this->viewEntity = new Rol();
            $this->childEntity = new ListingAcceso();
            $this->viewName = 'v_rol';
            $this->title = 'Roles';
            $this->subscribe();
        }        
        public function Index()
        {   
            $this->getData();
            return $this->getView('index');
        }
        public function Details(int $id=0, entity $entidad = null){
            $this->setViewBag();
            if(!$this->getData($id,$entidad)){
                // $this->update();
                return $this->Index();
            }
            $acceso = new Acceso();
            $this->viewBag->accesos = $acceso->ReturnList();
            return $this->getView('details');
            
        }
    }
    
    $obj = new RolController();
    $obj->RedirectToAction($_REQUEST);
   
?>