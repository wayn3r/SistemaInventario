<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Rol extends entity {
        public $idRol;
        public $rol;

        public function __construct()
        {
            $this->addAttribute('rol');
            $this->tableName = 'rol';
            $this->childTableName = 'vw_accesos';
            $this->idName = 'idRol';
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