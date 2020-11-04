<?php
namespace Model;
require_once('db/db_entity.php');
use Model\db\entity;

class Entrega extends entity {
        public $idEntrega;
        public $idPerfil;
        public $idEmpleado;
        public $fechaEntrega;
        public $terminado;

        public function __construct()
        {
            $this->addAttribute('idPerfil');
            $this->addAttribute('idEmpleado');
            $this->addAttribute('fechaEntrega');
            $this->addAttribute('terminado');
            $this->idName = 'idEntrega';
            $this->tableName = 'entrega';
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