<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;
    use Model\db\conexion;

    class TonerImpresora extends entity {
        public $idToner;
        public $idImpresora;
        public $secondId;
        
        public function __construct()
        {

            $this->addAttribute('idImpresora');
            $this->tableName = 'toner_impresora';
            $this->idName = 'idToner';
            $this->secondId = 'idImpresora';
        }
        public function __set($var,$value){
        
            $this->$var=$value;
            
        }
        public function __get($name)
        {
            if(isset($this->$name))
                return $this->$name;
        }

       public function Remove(int $idToner, int $idImpresora=0)
       {
            $sql = "delete from {$this->tableName} where {$this->idName} = '{$idToner}'";
            if($idImpresora > 0){
                $sql .="and {$this->secondId} = '{$idImpresora}'";
            }
            $sql .=";";

            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('eliminado');
            return $conex;
       }
       public function Add(entity $entidad){
           $idToner = $this->idName;
           $idToner = $entidad->$idToner;
           $idImpresora = $this->secondId;
           $idImpresora = $entidad->$idImpresora;
            $sql = "insert into {$this->tableName} 
            values({$idToner},{$idImpresora});";

            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('insertado');
            return $conex;
       }

    }
?>