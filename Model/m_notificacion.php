<?php

namespace Model;
require_once('db/db_entity.php');
use Model\db\entity;

class Notificacion extends entity {
    public $idNotificacion;
    public $fecha;
    public $tipoArticulo;
    public $modelo;
    public $total;
    public $restante;
    public $mensaje;
    public $visto;
    public $infoAdicional;

    public function __construct()
    {
        $this->addAttribute('fecha');
        $this->addAttribute('tipoArticulo');
        $this->addAttribute('modelo');
        $this->addAttribute('total');
        $this->addAttribute('restante');
        $this->addAttribute('mensaje');
        $this->addAttribute('visto');
        $this->addAttribute('infoAdicional');
        $this->idName = 'idNotificacion';
        $this->tableName = 'notificacion';
    }
    public function __set($var,$value){
        $this->$var=$value;
    }
    public function __get($name)
    {
        if(isset($this->$name))
            return $this->$name;
    }

    public function SetMessage(){
        if($this->mensaje == null){
            $this->mensaje = 'Queda';
            $cociente = ($this->total==0?$this->restante:$this->restante / $this->total);
            switch($cociente){
                case 1/2:
                    $this->mensaje .= ' la mitad de existencias';
                break;
                case 1/3:
                    $this->mensaje .= ' un tercio de existencias';
                break;
                case 0:
                    $this->mensaje = 'No quedan existencias';
                break;
                default:
                    $this->mensaje .= ($this->restante==1?' ':'n ').$this->restante.' existencia'.($this->restante==1?'':'s');

                break;
            }
            $this->mensaje .= ' en stock de este articulo: '.$this->tipoArticulo.' '.$this->modelo;
        }
    }

    public function SetInfo(){
        if($this->infoAdicional == null){
            $this->infoAdicional = 'Total: '.$this->total.' | Restante: '.$this->restante;
        }
    }

    public function setAttribute(array $entidad){
        
        foreach($this->attributes as $atributo){
            if(isset($entidad[$atributo]))                    
                $this->$atributo = $entidad[$atributo];
            else
                $this->$atributo = null;
        }
        $this->SetMessage();
        $this->SetInfo();
        $id = $this->idName; 
        if(isset($entidad[$id]))
            $this->$id = $entidad[$id]; 
        return $this;
    }


}

?>