<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingArticulos extends entity{
    public $idArticulo;
    public $modelo;
    public $idMarca;
    public $marca;
    public $idTipoArticulo;
    public $tipoArticulo;
    public $idCategoria;
    public $categoria;
    public $fechaInventario;
    public $fechaCompra;
    public $cantidadContada;
    public $cantidadStock;

    public function __construct()
    {
        $this->addAttribute('idArticulo');
        $this->addAttribute('modelo');
        $this->addAttribute('idMarca');
        $this->addAttribute('marca');
        $this->addAttribute('idTipoArticulo');
        $this->addAttribute('tipoArticulo');
        $this->addAttribute('idCategoria');
        $this->addAttribute('categoria');
        $this->addAttribute('fechaInventario');
        $this->addAttribute('fechaCompra');
        $this->addAttribute('cantidadContada');
        $this->addAttribute('cantidadStock');
        $this->tableName = 'articulo';
        $this->idName = 'idArticulo';
        $this->childTableName='vw_existencias';
        $this->view='vw_articulos';
    }
    public function __set($var,$value){
    
        $this->$var=$value;
       
        
    }
    public function __get($name)
    {
        if(isset($this->$name))
            return $this->$name;
    }

}

?>