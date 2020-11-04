<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingEntregas extends entity{

    public $idEntrega;
    public $recibidoPor;
    public $entregadoPor;
    public $fechaEntrega;
    public $terminado;
    public $idDepartamento;
    public $departamento;
    public $idEmpleado;
    public $idPerfil;
    public $codigoEmpleado;
    public $totalArticulos;
    
    public function __construct()
    {
        $this->addAttribute('idEntrega');
        $this->addAttribute('recibidoPor');
        $this->addAttribute('idPerfil');
        $this->addAttribute('entregadoPor');
        $this->addAttribute('fechaEntrega');
        $this->addAttribute('terminado');
        $this->addAttribute('idDepartamento');
        $this->addAttribute('departamento');
        $this->addAttribute('idEmpleado');
        $this->addAttribute('codigoEmpleado');
        $this->addAttribute('totalArticulos');
        $this->tableName = 'entrega';
        $this->view = 'vw_entregas';
        $this->idName = 'idEntrega';
        $this->childTableName = 'vw_detalles_entregas';
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