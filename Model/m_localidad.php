<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Localidad extends entity {
        public $idLocalidad;
        public $localidad;

        public function __construct()
        {
            $this->addAttribute('localidad');
            $this->tableName = 'localidad';
            $this->idName = 'idLocalidad';
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