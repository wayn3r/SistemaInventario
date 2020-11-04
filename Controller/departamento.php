<?php
    namespace Controller;
    require_once('../Model/m_departamento.php');
    require_once('../Model/m_empleado.php');
    require_once('../Controller/_controller.php');
    use Model\Categoria;
use Model\db\entity;
use Model\Departamento;
use Model\Empleado;
use Model\TipoArticulo;

class DepartamentoController extends Controller{

        public function __construct(){
            $this->entity = new Departamento();
            $this->viewEntity = new Departamento();
            $this->childEntity = new Empleado();
            $this->viewName = 'v_departamento';
            $this->title = 'Departamentos';
            $this->subscribe();
        }
        
        public function Index()
        {
            $this->setViewBag();
            $this->getData();
            return $this->getView('index',false);
        }
        public function Details(int $id=0, entity $entidad = null){
            $this->setViewBag();
            if(!$this->getData($id,$entidad)){
                return $this->Index();
            }
            return $this->getView('details', false);
            
        }
    }
    
    $obj = new DepartamentoController();
    $obj->RedirectToAction($_REQUEST);
   
?>