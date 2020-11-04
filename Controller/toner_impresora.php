<?php
    namespace Controller;
    require_once('../Model/m_toner_impresora.php');
    require_once('../Controller/_controller.php');

use Model\TonerImpresora;

class TonerController extends Controller{

    public function __construct(){
        $this->entity = new TonerImpresora();
        $this->viewEntity = $this->entity;
        $this->viewName = 'v_';
        $this->subscribe();
    }

    public function Remove(int $idT, int $idI = 0)
    {
        $this->entity->Remove($idT, $idI);
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
                        $idT = intval($http['idT']);
                        $idI = intval($http['idI']);
                        $this->Remove($idT,$idI);
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
    
    $obj = new TonerController();
    $obj->RedirectToAction($_REQUEST);
       
?>