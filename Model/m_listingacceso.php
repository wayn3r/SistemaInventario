<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class ListingAcceso extends entity {
        public $idRol;
        public $rol;
        public $idAcceso;
        public $controlador;
        public $pagina;

        public function __construct()
        {
            $this->addAttribute('rol');
            $this->addAttribute('idAcceso');
            $this->addAttribute('controlador');
            $this->addAttribute('pagina');
            $this->tableName = 'rol_acceso';
            $this->childTableName = 'vw_accesos';
            $this->view = 'vw_accesos';
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