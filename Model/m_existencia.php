<?php
    namespace Model;
    require_once('db/db_entity.php');
    require_once('../Observer/interfaces.php');
    use Model\db\entity;


class Existencia extends entity {
        public $idExistencia;
        public $idArticulo;
        public $idEstado;
        public $fechaInventario;
        public $fechaCompra;
        public function __construct()
        {
            $this->addAttribute('idArticulo');
            $this->addAttribute('idEstado');
            $this->addAttribute('fechaInventario');
            $this->addAttribute('fechaCompra');
            $this->fechaInventario = date('Y-m-d');
            $this->tableName = 'existencia';
            $this->idName = 'idExistencia';
            $this->subscribers = array();
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