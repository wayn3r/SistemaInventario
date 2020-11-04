<?php
namespace Model\db;
require_once('db_dataset.php');

use stdClass;

abstract class entity extends db{
    public $attributes = [];
    public function addAttribute($var){
        $this->attributes[] = $var;
    }

    public function setAttribute(array $entidad){
        
        foreach($this->attributes as $atributo){
            if(isset($entidad[$atributo]))                    
                $this->$atributo = $entidad[$atributo];
            else
                $this->$atributo = null;
        }
        $id = $this->idName; 
        if(isset($entidad[$id]))
            $this->$id = $entidad[$id]; 
        return $this;
    }

    public function getClone(){
        $var = new stdClass;
        foreach($this->attributes as $atributo){
            $var->$atributo = $this->$atributo;
        }
        $id = $this->idName;
        $var->$id = $this->$id;
        return $var;
    }

    public function ReturnList(string $where = null, string $orderby = null, bool $desc = false){
        $list = [];
        foreach($this->List($where, $orderby, $desc) as $fila){
            $this->setAttribute($fila);
            $list[] = $this->getClone();
        }
        return $list;
    }
}
?>