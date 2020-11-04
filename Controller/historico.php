<?php
    namespace Controller;
    require_once('../Model/m_historicoimpresora.php');
    require_once('../Model/m_historicoarticulo.php');
    require_once('../Model/m_historicofecha.php');
    require_once('../Controller/_controller.php');

use HistoricoArticulos;
use HistoricoImpresoras;
use Model\Fecha;

class HistoricoController extends Controller{

        public function __construct(){
            $this->viewEntity = new Fecha();
            $this->entity = new HistoricoArticulos();
            $this->viewName = 'v_historico';
            $this->title = 'Historicos';
            $this->subscribe();
        } 
       
        public function Index(array $respuesta = null)
        {   
            $this->setViewBag();
            $this->viewBag->fechas = $this->viewEntity->ReturnList(null,'fecha',true);
            $this->viewBag->historico = $respuesta;
            return $this->getView('index', false);
        }

        public function Historio(array $http){
            if(isset($http['tipo'])){
                switch($http['tipo']){
                    case 'impresora':
                        $historico = new HistoricoImpresoras();
                    break;
                    case 'articulo':
                        $historico = new HistoricoArticulos();
                    break;
                    default:
                        $http['tipo'] = 'articulo';
                        $historico = new HistoricoArticulos();
                    break;
                }
                //buscando la fecha
                if(isset($http['fecha']))
                    $fecha = $this->viewEntity->FindByField('fecha',$http['fecha']);
                else if(isset($http['id']) && is_numeric($http['id']))
                    $fecha = $this->viewEntity->Find($http['id']);
                else
                    return $this->Index(['error'=>true]);

                if(count($fecha) > 0){
                    $historico = $historico->ReturnList("idFecha = '{$fecha[0]['idFecha']}'");
                    $this->setViewBag();
                    $this->viewBag->data = $historico;
                    $this->viewBag->fecha = $fecha[0];
                    return $this->getView($http['tipo'],false);
                }
                else{
                    return $this->Index(['error'=>'La fecha seleccionada no esta registrada']);
                }
            }
            else{
                return $this->Index(['error'=>true]);
            }
        }
        public function Registrar(){
            $this->entity->CrearHistorico();
            return $this->Index();
        }

        public function RedirectToAction(array $http){
            if(isset($http['accion'])){
                switch($http['accion']){
                    case "Historico":
                    return $this->Historio($http);
                    case'Inventario':
                    return $this->Registrar();

                    default:
                    return $this->Index();                                     
                }                                
            }
            else {
                return $this->Index();
            }
            
    }

    }
    
    $obj = new HistoricoController();
    $obj->RedirectToAction($_REQUEST);
   
?>