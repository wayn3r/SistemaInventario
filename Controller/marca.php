<?php
    namespace Controller;
    require_once('../Model/m_marca.php');
    require_once('../Model/m_listingarticulo.php');
    require_once('../Controller/_controller.php');

use ListingArticulos;
use ListingTipoArticulos;
use Model\Marca;
use Model\TipoArticulo;

class MarcaController extends Controller{

        public function __construct(){
            $this->entity = new Marca();
            $this->viewEntity = new Marca();
            $this->childEntity = new ListingArticulos();
            $this->viewName = 'v_marca';
            $this->title = 'Marcas';
            $this->subscribe();
        }
    }
    
    $obj = new MarcaController();
    $obj->RedirectToAction($_REQUEST);
       
    

   
?>