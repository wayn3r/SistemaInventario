<?php
    namespace Controller;
    require_once('../Model/m_correo.php');
    require_once('../Model/m_tipoarticulo.php');
    require_once('../Controller/_controller.php');
    use Model\Correo;
use Model\db\entity;

class CorreoController extends Controller{

    public function __construct(){
        $this->entity = new Correo();
        $this->viewEntity = new Correo();
        $this->childEntity = $this->entity;
        $this->viewName = 'v_correo';
        $this->title = 'Correos';
        $this->subscribe();
    } 
    
    public function Index()
    {
        $this->setViewBag();
        $this->getData();
        $this->getView('index', false);
    }
    public function Details(int $id=0, entity $entidad = null){         
        $this->Index();
    }
}
    
    $obj = new CorreoController();
    $obj->RedirectToAction($_REQUEST);
   
?>