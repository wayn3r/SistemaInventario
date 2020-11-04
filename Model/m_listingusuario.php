<?php
require_once('db/db_entity.php');
use Model\db\entity;

class ListingUsuarios extends entity{
    public $idUsuario;
    public $user;
    public $idPerfil;
    public $nombreCompleto;
    public $idRol;
    public $rol;
    public $fechaCreacion;

    public function __construct()
    {

        $this->addAttribute('idUsuario');
        $this->addAttribute('user');
        $this->addAttribute('idPerfil');
        $this->addAttribute('nombreCompleto');
        $this->addAttribute('idRol');
        $this->addAttribute('rol');
        $this->addAttribute('fechaCreacion');
        $this->tableName = 'usuario';
        $this->view = 'vw_usuarios';
        $this->childTableName = 'vw_usuarios';
        $this->idName = 'idUsuario';
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