<?php
    namespace Controller;
    require_once('../Model/m_rol_acceso.php');
    require_once('../Controller/_controller.php');

use Model\RolAcceso;

class RolAccesoController extends Controller{

    public function __construct(){
        $this->entity = new RolAcceso();
        $this->viewEntity = $this->entity;
        $this->viewName = 'v_';
        $this->subscribe();
    }

    public function Remove(int $idR, int $idA = 0)
    {
        $this->entity->Remove($idR, $idA);
        $this->Index(); 
    }
    public function RedirectToAction(array $http)
    {
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
                        if(is_numeric($http['idR']) && is_numeric($http['idA']))
                        $this->Remove($http['idR'],$http['idA']);
                    }catch(\Exception $e){}      
                break;
            }
        }
        else if(!isset($http['fv'])){
            $_GET['fv'] = 'home';
            $this->Index();
        }
    }
}
    
    $obj = new RolAccesoController();
    $obj->RedirectToAction($_REQUEST);
       
?>