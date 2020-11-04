<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Correo extends entity {
        public $idCorreo;
        public $correo;

        public function __construct()
        {
            $this->addAttribute('correo');
            $this->tableName = 'correo';
            $this->childTableName = 'correo';
            $this->idName = 'idCorreo';
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