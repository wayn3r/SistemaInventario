<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Marca extends entity {
        public $idMarca;
        public $marca;

        public function __construct()
        {
            $this->addAttribute('marca');
            $this->tableName = 'marcaarticulo';
            $this->idName = 'idMarca';
            $this->childTableName = 'vw_marcas';
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