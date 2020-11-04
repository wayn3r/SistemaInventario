<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Departamento extends entity {
        public $idDepartamento;
        public $departamento;

        public function __construct()
        {
            $this->addAttribute('departamento');
            $this->tableName = 'departamento';
            $this->childTableName = 'empleado';
            $this->idName = 'idDepartamento';
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