<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Fecha extends entity {
        public $idFecha;
        public $fecha;

        public function __construct()
        {
            $this->addAttribute('fecha');
            $this->tableName = 'historico_fecha';
            $this->idName = 'idFecha';
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