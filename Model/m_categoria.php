<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Categoria extends entity {
        public $idCategoria;
        public $categoria;

        public function __construct()
        {
            $this->addAttribute('categoria');
            $this->tableName = 'categoria';
            $this->childTableName = 'tipoarticulo';
            $this->idName = 'idCategoria';
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