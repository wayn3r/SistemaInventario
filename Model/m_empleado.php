<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Empleado extends entity {
        public $idEmpleado;
        public $codigoEmpleado;
        public $nombre;
        public $apellido;
        public $correo;
        public $fechaEntrada;
        public $activo;
        public $idDepartamento;

        public function __construct()
        {
            $this->addAttribute('codigoEmpleado');
            $this->addAttribute('nombre');
            $this->addAttribute('apellido');
            $this->addAttribute('correo');
            $this->addAttribute('fechaEntrada');
            $this->addAttribute('idDepartamento');
            $this->addAttribute('activo');
            $this->tableName = 'empleado';
            $this->childTableName = 'tipoarticulo';
            $this->idName = 'idEmpleado';
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