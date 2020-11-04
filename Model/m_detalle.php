<?php
namespace Model;
require_once('db/db_entity.php');
use Model\db\entity;

class Detalle extends entity {
        public $idEntrega;
        public $idExistencia;

        public function __construct()
        {
            $this->addAttribute('idExistencia');
            $this->idName = 'idEntrega';
            $this->tableName = 'existencia_entrega';
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