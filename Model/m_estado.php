<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Estado extends entity {
        public $idEstado;
        public $estado;

        public function __construct()
        {
            $this->addAttribute('idEstado');
            $this->addAttribute('estado');
            $this->tableName = 'estado';
            $this->idName = 'idEstado';
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