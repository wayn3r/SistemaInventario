<?php
    namespace Controller;
    require_once('../Model/m_empleado.php');
    require_once('../Model/m_listingempleado.php');
    require_once('../Model/m_departamento.php');
    require_once('../Controller/_controller.php');

use Model\Departamento;
use Model\Empleado;
use Model\ListingEmpleado;

class EmpleadoController extends Controller{

        public function __construct(){
            $this->entity = new Empleado();
            $this->viewEntity = new ListingEmpleado();
            $this->viewName = 'v_empleado';
            $this->title = 'Empleados';
            $this->subscribe();
        }        
    
    
    public function Index(){
        $this->setViewBag();
        $this->getData();
        $dep = new Departamento();
        $this->viewBag->departamentos = $dep->ReturnList();
        return $this->getView('index',false);
    }
}
    $obj = new EmpleadoController();
    $obj->RedirectToAction($_REQUEST);
   
?>