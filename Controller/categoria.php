<?php
    namespace Controller;
    require_once('../Model/m_categoria.php');
    require_once('../Model/m_tipoarticulo.php');
    require_once('../Controller/_controller.php');
    use Model\Categoria;
use Model\db\entity;
use Model\TipoArticulo;

class CategoriaController extends Controller{

        public function __construct(){
            $this->entity = new Categoria();
            $this->viewEntity = new Categoria();
            $this->childEntity = new TipoArticulo();
            $this->viewName = 'v_categoria';
            $this->title = 'Categorias';
            $this->subscribe();
        }        
    }
    
    $obj = new CategoriaController();
    $obj->RedirectToAction($_REQUEST);
   
?>