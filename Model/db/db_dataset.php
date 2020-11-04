<?php
namespace Model\db;
require_once('conexion.php');
require_once('db_entity.php');
require_once('../Observer/interfaces.php');
use Model\db\conexion;
use Observer\{iSubject, iSubscriber};

abstract class db implements iSubject{
        protected $tableName;
        protected $idName;
        protected $childTableName;
        public $view;
        private $subscribers;

        public function CrearHistorico(){
            $sql = 'call proc_crear_historico();';
            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('creado');
            return $conex;
        }
        public function Add(entity $entidad,int $repeticiones = 1){
            $sql = "insert into {$this->tableName} 
            values ";
            for($x=0;$x<$repeticiones;$x++){
                $sql.="(null,";
                foreach($entidad->attributes as $atributo){
                    $sql.= "'{$entidad->$atributo}',";
                }
                $sql = trim($sql,',');
                $sql.="),";
            } 
            $sql = trim($sql,',');
            $sql .= ";";
            
            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('agregado');
            return $conex;
        }
        public function AddSeveral(array $entidades){
            $sql = "insert into {$this->tableName} 
            values ";
            foreach($entidades as $entidad){ 
                $sql.='(null,';
                foreach($entidad->attributes as $atributo){
                    $sql.= "'{$entidad->$atributo}',";
                }
                $sql = trim($sql,',');                
                $sql .="),";
            }
            $sql = trim($sql,',');
            $sql .= ";";
            
            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('agregado');
            return $conex;
        }
        public function EditFields(string $field, string $newValue, string $oldValue, int $id = 0){
            $sql = "update {$this->tableName} set {$field} = '{$newValue}' where ";
            if($id > 0){
                $sql.="{$this->idName} = '{$id}';"; 
            }
            else
            {
                $sql.="{$field} = '{$oldValue}';";
            }
            
            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('actualizado');
            return $conex;
        }
        public function Edit(entity $entidad){
            $sql = "update {$this->tableName} set ";
            foreach($entidad->attributes as $atributo){
                if(!is_null($entidad->$atributo)){
                    $sql .= "{$atributo} = ";
                    if(is_numeric($entidad->$atributo))
                        $sql.="{$entidad->$atributo}, ";
                    else
                        $sql.="'{$entidad->$atributo}', ";
                }                
            }
            $sql = trim($sql,', ');           
            $id = $this->idName;
            $sql .= " where {$id} = '{$entidad->$id}';";

            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('actualizado');
            return $conex;
        }
        public function Remove(int $id){
            $sql = "delete from {$this->tableName} where {$this->idName} = '{$id}';";

            $conex = conexion::getInstance();
            $conex = $conex->query($sql);
            $this->notify('eliminado');
            return $conex;
        }
        public function List(string $where=null, string $orderby = null, bool $desc = false){
            if(!isset($this->view))
                $this->view = $this->tableName;
                
            $sql = "select * from {$this->view}";
            //agregando clausula where
            if($where != null)
                $sql .=" where {$where}";
            //agregando clausula order by
            if($orderby != null)
                $sql .=" order by {$orderby} ".($desc?'desc':'asc');

            $sql .=';';
            $conex = conexion::getInstance();
            return $conex->query($sql);
            
        }
        public function FindByField(string $field, string $search){
            if(!isset($this->view))
                $this->view = $this->tableName;

            $sql = "select * from {$this->view} where {$field} = '{$search}';";
            $conex = conexion::getInstance();
            return $conex->query($sql);
        }
        public function Find(int $id, entity $entidad = null){
            if(!isset($this->view))
                $this->view = $this->tableName;

            $sql = "select * from {$this->view} where";
            if($id > 0)
                $sql .= " {$this->idName} = '{$id}'";
            else if($entidad != null)
                foreach($entidad->attributes as $atributo){
                    $sql .= " {$atributo} = '%{$entidad->$atributo}%' or ";
                }
            
            $sql = trim($sql,'or ');
            $sql .= ";";
            $conex = conexion::getInstance();
            return $conex->query($sql);

        }
        public function getChildren(int $id, entity $childEntity){
            if(isset($this->childTableName)){
                $sql = "select * from {$this->childTableName} where {$this->idName} = '{$id}';";
                $conex = conexion::getInstance();
                $registrosHijos = $conex->query($sql);
                $children = [];
                foreach($registrosHijos as $child){
                    $id = array_key_first($child);
                    if($child[$id] != null){
                        $childEntity->setAttribute($child);
                        $children[] = $childEntity->getClone();
                    }
                }
                return $children;
            }
            
        }
        public function getSideBarData(bool $view_categorias, bool $view_marcas){
            $categorias=null;
            $marcas=null;
            if($view_categorias){
               $categorias = $this->getViewData('idCategoria');
            }
            if($view_marcas){
              $marcas = $this->getViewData('idMarca');
            }
            $data['categorias']=$categorias;
            $data['marcas']=$marcas;
            return $data;
        }
        private function getViewData(string $idName){
            $conex = conexion::getInstance();
            $field = strtolower(trim($idName,'id'));
            $view = "vw_{$field}s";
            $sql = "select {$idName}, {$field} from {$view} group by {$idName}";

            $viewData = $conex->query($sql);
            $n = 0;
            foreach($viewData as $row){
                $viewData[$n]['tipoArticulos'] = $this->getTipoArticulo($view,$idName,$row[$idName]);
                $n++;
            }
            return $viewData;
        }
        private function getTipoArticulo(string $view,string $idName,int $id){
            $sql = "select idTipoArticulo, tipoArticulo from {$view} where {$idName} = '{$id}' group by idTipoArticulo;";
            $conex = conexion::getInstance();
            $tipoArticulo = $conex->query($sql);
            return $tipoArticulo;
        }
        public function addSubscriber(iSubscriber $sub)
        {
            if(!is_array($this->subscribers))
                $this->subscribers = [];
            $this->subscribers[] = $sub;
        }
        public function removeSubscriber(iSubscriber $sub)
        {
            $clave = array_search($sub,$this->subscribers);
            if(!is_bool($clave))
                unset($this->subscribers[$clave]);
        }
        public function notify(string $evento)
        {
            $conex = conexion::getInstance();
            $info = $conex->getResult();
            $info->evento = $evento;
            //obteniendo el nombre de la entidad desde el idName
            $info->entidad = strtolower(trim($this->idName,'id'));
            $info->entidad .= ($info->rows > 1?(substr($info->entidad,strlen($info->entidad) - 1,1) == 'a' || 'e' || 'i' || 'o' || 'u' ?'s':'es'):'');
            //////////////////
            if(isset($this->subscribers))
            foreach($this->subscribers as $sub){
                $sub->update($info);
            }
        }
        public function GetLastId(){
            $conex = conexion::getInstance();
            return $conex->GetLastId();
        }

        public function AddDetalle(int $idEntrega, int $idArticulo, int $cantidad){
            $crearDetalle = "call proc_crear_detalle ({$idEntrega}, {$idArticulo}, {$cantidad});";

            $conex = conexion::getInstance();
            $conex->query($crearDetalle);
            $this->notify('agregado');
            return $conex;
        }
        public function RemoveDetalle(int $idEntrega, int $idArticulo, int $cantidad){
            $eliminarDetalle = "call proc_eliminar_detalle ({$idEntrega}, {$idArticulo}, {$cantidad});";

            $conex = conexion::getInstance();
            $conex->query($eliminarDetalle);
            $this->notify('eliminado');
            return $conex;
        }
    }
    

?>