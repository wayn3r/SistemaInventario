<?php
    namespace Controller;
    require_once('../Model/m_notificacion.php');
    require_once('../Controller/_controller.php');

use Model\db\entity;
use Model\Notificacion;
use Model\TonerImpresora;

class NotificacionController extends Controller{

    public function __construct(){
        $this->entity = new Notificacion();
        $this->viewEntity = $this->entity;
        $this->viewName = 'v_';
        $this->subscribe();
    }

    public function Edit(array $entidad)
    {
        if(isset($entidad['idNotificacion']))
            if($entidad['idNotificacion'] == 'all'){
            $this->entity->EditFields('visto','1','0');
            }
            else{
                $this->entity->idNotificacion = $entidad['idNotificacion'];
                $this->entity->visto = 1;
                $this->entity->Edit($this->entity);
            }
        $this->Index();
    }

    public function Index(){

        // verificando redireccionamiento y enviando datos de toast de ser necesaria
        return $this->RedirectToView(['fv'=>$_GET['fv'], 'id'=>$_GET['id']],['info'=>serialize($this->result->info)]);
    }

    public function RedirectToAction(array $http){
        if(isset($http['accion'])){
            switch($http['accion']){
                case "Edit":
                    return $this->Edit($http);
                break;
                case "Remove":
                    try{
                        $id = intval($http['idNot']);
                       return $this->Remove($id);
                    }catch(\Exception $e){}      
                break;
                default:
                return $this->Index();
                                 
            }            
        }
        return $this->Index();
    }

}
    
    $obj = new NotificacionController();
    $obj->RedirectToAction($_REQUEST);
       
?>