<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Acceso extends entity {
        public $idAcceso;
        public $controlador;
        public $pagina;

        public function __construct()
        {
            $this->addAttribute('controlador');
            $this->addAttribute('pagina');
            $this->tableName = 'acceso';
            $this->idName = 'idAcceso';
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