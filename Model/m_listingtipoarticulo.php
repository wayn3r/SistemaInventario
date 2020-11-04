<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingTipoArticulos extends entity{
    public $idTipoArticulo;
    public $tipoArticulo;
    public $idCategoria;
    public $categoria;

    public function __construct()
    {

        $this->addAttribute('idTipoArticulo');
        $this->addAttribute('tipoArticulo');
        $this->addAttribute('idCategoria');
        $this->addAttribute('categoria');
        $this->tableName = 'tipoarticulo';
        $this->view = 'vw_tipoarticulos';
        $this->childTableName = 'vw_articulos';
        $this->idName = 'idTipoArticulo';
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