<?php
    namespace Model;
    require_once('db/db_entity.php');
    use Model\db\entity;
    use Model\db\conexion;

    class RolAcceso extends entity {
        public $idRol;
        public $idAcceso;
        public $secondId;
        
        public function __construct()
        {
            $this->addAttribute('idAcceso');
            $this->tableName = 'rol_acceso';
            $this->idName = 'idRol';
            $this->secondId = 'idAcceso';
        }
        public function __set($var,$value){
        
            $this->$var=$value;
            
        }
        public function __get($name)
        {
            if(isset($this->$name))
                return $this->$name;
        }

       public function Remove(int $idRol, int $idAcceso=0)
       {
            $sql = "delete from {$this->tableName} where {$this->idName} = '{$idRol}'";
            if($idAcceso > 0){
                $sql .="and {$this->secondId} = '{$idAcceso}'";
            }
            $sql .=";";

            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('eliminado');
            return $conex;
       }
       public function Add(entity $entidad, int $repeticiones = 0){
           $idRol = $this->idName;
           $idRol = $entidad->$idRol;
           $idAcceso = $this->secondId;
           $idAcceso = $entidad->$idAcceso;
            $sql = "insert into {$this->tableName} 
            values({$idRol},{$idAcceso});";

            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('insertado');
            return $conex;
       }

    }
?>