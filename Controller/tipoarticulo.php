<?php
    namespace Controller;
    require_once('../Model/m_listingtipoarticulo.php');
    require_once('../Model/m_tipoarticulo.php');
    require_once('../Model/m_categoria.php');
    require_once('../Model/m_marca.php');
    require_once('../Model/m_listingarticulo.php');
    require_once('../Model/m_listingtoner.php');
    require_once('../Controller/_controller.php');

use ListingArticulos;
use ListingTipoArticulos;
use ListingToners;
use Model\Categoria;
use Model\db\entity;
use Model\Marca;
use Model\TipoArticulo;

class TipoArticuloController extends Controller{

        public function __construct(){
            $this->entity = new TipoArticulo();
            $this->viewEntity = new ListingTipoArticulos();
            $this->childEntity = new ListingArticulos();
            $this->viewName = 'v_tipoarticulo';
            $this->title = 'Articulos';
            $this->subscribe();
        }


        public function Index(){
            $this->setViewBag(); //creando variable viewBag
            //devolviendo categorias para index
            $options = new Categoria();
            $list = $options->ReturnList(); //obteniendo lista de categorias 
            $this->viewBag->opciones = $list;
            $this->getData();// obteniendo datos de las vista
            $this->getView('index',true);//devoliendo la vista
        }

        public function Details(int $id = 0, entity $entidad = null)
        {
            $this->setViewBag();
            //devolviendo marcas para details
            $options = new Marca();
            $list = $options->ReturnList();//obteniendo lista de marcas 
            $this->viewBag->opciones = $list;            
            if(!$this->getData($id,$entidad)){
                return $this->Index();
            }
            $isPrinter = trim(strtolower($this->viewBag->data[0]->tipoArticulo),'s') == 'impresora';
            if($isPrinter){
                $toners = new ListingArticulos();
                $this->viewBag->toners = $toners->ReturnList("tipoArticulo like 'toner%' or categoria like 'toner%'");//obteniendo lista de toners
                
                $toners = new ListingToners();
                $n = count($this->viewBag->children);
                for($x=0; $x < $n; $x++){
                    $this->viewBag->children[$x]->toners = $toners->ReturnList("idImpresora = {$this->viewBag->children[$x]->idArticulo}");
                }//obteniendo lista de toners por impresora
            }

            //obteniendo datos de la vista
            return $this->getView('details',true);//devoliendo la vista
        }
    }
    
    
    $obj = new TipoArticuloController();
    $obj->RedirectToAction($_REQUEST);
       
    

   
?>