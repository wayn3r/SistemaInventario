<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

class Articulo extends entity {
        public $idArticulo;
        public $idTipoArticulo;
        public $idMarca;
        public $modelo;

        public function __construct()
        {
            $this->addAttribute('idTipoArticulo');
            $this->addAttribute('idMarca');
            $this->addAttribute('modelo');
            $this->idName = 'idArticulo';
            $this->tableName = 'articulo';
                        
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