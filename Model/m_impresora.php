<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Impresora extends entity {
        public $idImpresora;
        public $serialNumber;
        public $direccionIp;
        public $idEstado;
        public $idArticulo;
        public $fechaInventario;
        public $fechaCompra;

        public function __construct()
        {
            $this->addAttribute('idArticulo'); 
            $this->addAttribute('idEstado'); 
            $this->addAttribute('serialNumber');
            $this->addAttribute('direccionIp'); 
            $this->addAttribute('fechaInventario'); 
            $this->addAttribute('fechaCompra'); 
            $this->tableName = 'impresora';
            $this->idName = 'idImpresora';
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