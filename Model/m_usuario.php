<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;

    class Usuario extends entity {
        public $idUsuario;
        public $user;
        public $pass;
        public $idPerfil;
        public $idRol;

        public function __construct()
        {
            $this->addAttribute('user');
            $this->addAttribute('pass');
            $this->addAttribute('idPerfil');
            $this->addAttribute('idRol');
            $this->tableName = 'usuario';
            $this->idName = 'idUsuario';
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