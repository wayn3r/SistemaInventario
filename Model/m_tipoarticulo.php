<?php
namespace Model;
require_once('db/db_entity.php');
use Model\db\entity;

class TipoArticulo extends entity {
        public $idTipoArticulo;
        public $tipoArticulo;
        public $idCategoria;

        public function __construct()
        {
            $this->addAttribute('tipoArticulo');
            $this->addAttribute('idCategoria');
            $this->idName = 'idTipoArticulo';
            $this->tableName = 'tipoarticulo';
            $this->childTableName = 'vw_articulos';
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