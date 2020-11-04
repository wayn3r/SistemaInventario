<?php
    namespace Controller;
    require_once('../Model/m_listingentrega.php');
    require_once('../Model/m_listingarticulo.php');
    require_once('../Model/m_listingreporte.php');
    require_once('../Model/m_listingimpresora.php');
    require_once('../Model/m_estado.php');
    require_once('../Model/m_marca.php');
    require_once('../Model/m_perfil.php');
    require_once('../filters/sesion.php');
    require_once('../Controller/_controller.php');

use filter\session;
use ListingArticulos;
use ListingEntregas;
use ListingImpresoras;
use ListingReportes;
use Model\Estado;
use Model\Marca;
use Model\Perfil;

class ReporteController extends Controller{

    public function __construct(){
        $this->entity = new ListingReportes();
        $this->viewName = 'v_reporte';
        $this->title = 'Reportes';
        $this->sesion = session::GetSession();
    }   
    public function Index(array $respuesta = null){
                    
        $this->setViewBag();
        $this->viewBag->data = $respuesta;
        $estados = new Estado();
        $marcas = new Marca();
        $this->viewBag->estados = $estados->ReturnList();
        $this->viewBag->marcas = $marcas->ReturnList();
        $this->getView('index', false);
        
    } 
    
    public function SetCanvasData(array $http){
        $this->setViewBag();
        $where = $this->GetWhereClause($http);
        if($where == null){
            return false;
        }
        $grafico = $this->entity->ReturnList("filtro = '{$http['filtro']}' and fecha {$where['where']}",'cantidad',true);
        $dato = [];
        $cant = [];
        foreach($grafico as $row){
            if(!isset($dato[$row->data])){
                $dato[$row->data] = $row->data;
                $cant[$row->data] = $row->cantidad;
            }
            else{
                $cant[$row->data] += $row->cantidad;
            }
        }
        $cantidad = [];
        foreach($cant as $row){
            $cantidad[] = $row;
        }
        $data = [];
        foreach($dato as $row){
            $data[] = $row;
        }

        $this->viewBag->canvas['data'] = json_encode($data);
        $this->viewBag->canvas['cantidad'] = json_encode($cantidad);
    }
    public function Reporte(array $http){
        if(isset($http['tipoImpresora'])){
            $http['tipo'] = $http['tipoImpresora'];
            $http['filtro'] = 'impresora';
        }
        if(isset($http['filtro']) && isset($http['tipo'])){
            // var_dump($http);
            if($http['filtro'] != 'impresora'){   
                $this->SetCanvasData($http);
            } 
            if(!is_bool($this->SetReportData($http))){
                return $this->getView('reporte',false);
            } 
        }
        $http['error'] = true;
        if(isset($http['tipoImpresora'])){
            unset($http['tipo']);
            unset($http['error']);
            $http['error']['impresora'] = true;
        }
        return $this->Index($http);
        
    }
    public function GetWhereClause(array $http){
        if($http['tipo'] != ''){
            //fecha
            require_once('../Model/functions.php');
            switch($http['tipo']){
                case 'mes':
                    if($http['mes'] != ''){
                        $year = explode('-',$http['mes'])[0];
                        $mes = getMonth($http['mes']);
                        return ['where'=>"like '{$http['mes']}%'", 'to'=>'para el mes de '.$mes.' '.$year,'mes'=>$mes,'year'=>$year];
                    }
                break;
                case 'dia':
                    if($http['dia'] != ''){
                        $year = explode('-',$http['dia'])[0];
                        $mes = getMonth($http['dia']);
                        $dia = explode('-',$http['dia'])[2];
                        return   ['where'=> "= '{$http['dia']}'", 'to'=>'para el dia '.$dia.' del mes de '.$mes.' de '.$year,'mes'=>$dia.' de '.$mes,'year'=>$year];
                    }
                break;
                case 'rango':
                    if($http['desde'] != '' && $http['hasta'] != ''){
                        return  ['where'=>"between '{$http['desde']}' and '{$http['hasta']}'",'to'=>'desde '.$http['desde']. ' hasta '.$http['hasta'],'mes'=>$http['desde'],'year'=>$http['hasta']];
                    }
                break;
                case 'estado':
                    if($http['idEstado'] != ''){
                        return  ['where'=>"idEstado = '{$http['idEstado']}'",'to'=>'segun su estado','mes'=>getMonth(date('Y-m')),'year'=>date('Y')];
                    }
                break;
                case 'fechaentrada':
                    if($http['desdefe'] != '' && $http['hastafe'] != ''){
                        return  ['where'=>"fechaInventario between '{$http['desdefe']}' and '{$http['hastafe']}'",'to'=>'segun su fecha de inventario desde '.$http['desdefe']. ' hasta '.$http['hastafe'],'mes'=>$http['desdefe'],'year'=>$http['hastafe']];
                    }
                break;
                case 'fechacompra':
                    if($http['desdefc'] != '' && $http['hastafc'] != ''){
                        return  ['where'=>"fechaCompra between '{$http['desdefc']}' and '{$http['hastafc']}'",'to'=>'segun su fecha de compra desde '.$http['desdefc']. ' hasta '.$http['hastafc'],'mes'=>$http['desdefc'],'year'=>$http['hastafc']];
                    }
                break;
                case 'marca':
                    if($http['idMarca'] != ''){
                        return  ['where'=>"idMarca = '{$http['idMarca']}'",'to'=>'segun su marca','mes'=>getMonth(date('Y-m')),'year'=>date('Y')];
                    }
                break;
            }
        }
        return null;
    }
    public function SetReportData(array $http){
        if(isset($http['tipoImpresora'])){
            $http['tipo'] = $http['tipoImpresora'];
            $http['filtro'] = 'impresora';
        }
        else if($http['mes'] !='' || $http['dia'] || ($http['desde'] !='' && $http['hasta'] != '')){
            $field = 'fechaInventario ';
        }
        $where = $this->GetWhereClause($http);
        if($where != null){
            switch($http['filtro']){
                case 'entrega':
                    $report = new ListingEntregas();
                    $data = $report->ReturnList("fechaEntrega {$where['where']}",'fechaEntrega, departamento');
                    $title = 'entregas';
                    $mensaje = 'Reporte de cantidad de entregas por departamento ';
                break;
                case 'articulo':
                    $report = new ListingArticulos();
                    $data = $report->ReturnList("fechaInventario {$where['where']}",'fechaInventario');
                    $title = 'articulos';
                    $mensaje = 'Reporte de cantidad de entrada de articulos a inventario ';
                break;
                case 'impresora':
                    $report = new ListingImpresoras();
                    $data = $report->ReturnList((isset($field)?$field:'')."{$where['where']}",'fechaInventario');
                    $title = 'impresoras';
                    $mensaje = 'Reporte de impresoras ';
                break;
                default:
                return false;
            }
        
            $this->setViewBag();  
            $this->viewBag->mes = $where['mes'];          
            $this->viewBag->year = $where['year'];
            $this->viewBag->tipo = $http['tipo'];          
            $this->viewBag->reporte = $http;
            $this->viewBag->data = $data;
            $this->viewBag->titulo = $title;
            $this->viewBag->mensaje = $mensaje . $where['to'];
            $user = $this->sesion->GetUser();
            $perfil = new Perfil();
            $this->viewBag->cuser = $perfil->Find($user->idPerfil)[0];
        }
        else{
            return false;
        }

    }
    public function RedirectToAction(array $http)
    {
        if(isset($http['accion'])){
            switch($http['accion']){
                case 'Reporte':
                   return $this->Reporte($http);
                break;
                case 'ReportePdf':
                break;
                default:
                    return $this->Index();
                break;
            }
        }
        else{
            return $this->Index();
        }

    }
    
}
    
    $obj = new ReporteController();
    $obj->RedirectToAction($_REQUEST);
   
?>