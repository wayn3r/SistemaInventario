<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Perfil extends entity {
        public $idPerfil;
        public $nombre;
        public $apellido;
        public $correo;
        public $fechaCreacion;
        public $idLocalidad;
        public $idDepartamento;

        public function __construct()
        {
            $this->addAttribute('nombre');
            $this->addAttribute('apellido');
            $this->addAttribute('correo');
            $this->addAttribute('fechaCreacion');
            $this->addAttribute('idLocalidad');
            $this->addAttribute('idDepartamento');
            $this->tableName = 'perfil';
            $this->idName = 'idPerfil';
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