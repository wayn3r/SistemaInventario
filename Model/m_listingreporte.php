<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingReportes extends entity{
    public $filtro;
    public $data;
    public $fecha;
    public $cantidad;

    public function __construct()
    {
        $this->addAttribute('filtro');
        $this->addAttribute('data');
        $this->addAttribute('fecha');
        $this->addAttribute('cantidad');
        $this->tableName = 'vw_reportes';
        $this->view = 'vw_reportes';
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