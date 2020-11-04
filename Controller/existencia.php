<?php
    namespace Controller;
    require_once('../Model/m_listingexistencia.php');
    require_once('../Model/m_listingtipoarticulo.php');
    require_once('../Model/m_existencia.php');
    require_once('../Model/m_articulo.php');
    require_once('../Model/m_estado.php');
    require_once('../Controller/_controller.php');

use ListingExistencias;
use ListingTipoArticulos;
use Model\Articulo;
use Model\Categoria;
use Model\db\entity;
use Model\Estado;
use Model\Existencia;

class ExistenciaController extends Controller{

        public function __construct(){
            $this->entity = new Existencia();
            $this->viewEntity = new ListingExistencias();
            $this->viewName = 'v_existencia';
            $this->title = 'Existencia';
            $this->subscribe();
        }

        public function Index()
        {
            $this->setViewBag();
            $articulos = new Articulo();
            $estados = new Estado();
            $this->viewBag->articulos = $articulos->ReturnList(); //obteniendo articulos para opciones de editar y agregar
            $this->viewBag->estados = $estados->ReturnList(); //obteniendo estados para opciones de editar y agregar
            $this->getData();
            $this->getView("index", true);
        }
        public function Details(int $id = 0, entity $entidad = null)
        {
            $this->setViewBag();
            $estados = new Estado();
            $list = $estados->ReturnList();
            $this->viewBag->estados = $list;
            if($this->getData($id,$entidad)){
                $categoria = new ListingTipoArticulos();
                $categoria = $categoria->Find($this->viewBag->data[0]->idTipoArticulo);//obteniendo categorias para la navegacion
                $this->viewBag->categorias = $categoria;
                return $this->getView("details", true);
            }
            return $this->Index();
        }
        public function Remove(int $id)
        {
            $this->Index();
        }
        public function Add(array $entidad){
               
            $this->entity->setAttribute($entidad);
            if(!isset($entidad['cantidad']))
                $entidad['cantidad'] = 1;

            $this->entity->Add($this->entity,$entidad['cantidad']);
            
            $this->Index();
        }

    }
    
    $obj = new ExistenciaController();
    $obj->RedirectToAction($_REQUEST);
       
    

   
?>