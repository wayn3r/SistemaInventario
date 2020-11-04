<?php
    namespace Controller;
    require_once('../Model/m_perfil.php');
    require_once('../Model/m_localidad.php');
    require_once('../Model/m_departamento.php');
    require_once('../Controller/_controller.php');

use filter\session;
use Model\db\entity;
use Model\Departamento;
use Model\Localidad;
use Model\Perfil;
    
    class PerfilController extends Controller{

        public function __construct(){
            $this->entity = new Perfil();
            $this->viewEntity = new Perfil();
            $this->viewName = 'v_perfil';
            $this->title = 'Perfil';
            $this->sesion = session::GetSession();
            $this->subscribe();
        }
        public function Index(array $entidad = null, int $id = 0){
            if($id > 0 && $this->sesion->IsAdmin()){
                $idPerfil = $id;
            }
            else{
                $user = $this->sesion->GetUser();   
                $idPerfil = $user->idPerfil;
            }
            $this->setViewBag();
           
            $this->viewBag->data = $this->entity->Find($idPerfil);
            $this->viewBag->data[0]['localidad'] = $this->SetLocalidad($this->viewBag->data[0]['idLocalidad']);

            $this->viewBag->data[0]['departamento'] = $this->SetDepartamento($this->viewBag->data[0]['idDepartamento']);
           

            if($entidad == null)
                $entidad = $this->viewBag->data[0];
            $this->viewBag->editar = $entidad;
            $this->getView('index', false);
            
        }
        private function SetDepartamento(int $idDepartamento)
        {
            $departamentos = new Departamento();
            $this->viewBag->departamentos = $departamentos->ReturnList();
            foreach($this->viewBag->departamentos as $departamento){
                if($departamento->idDepartamento == $idDepartamento){
                    return $departamento->departamento;
                }
            }
        }
        private function SetLocalidad(int $idLocalidad)
        {
            $localidades = new Localidad();
            $this->viewBag->localidades = $localidades->ReturnList();
            foreach($this->viewBag->localidades as $localidad){
                if($localidad->idLocalidad == $idLocalidad){
                    return $localidad->localidad;
                }
            }
        }

        public function Edit(array $entidad){
            $user = $this->sesion->GetUser(); 
            $autorizado = $user->pass === md5($entidad['pass-gc']);
            if($autorizado){
                $localidad = explode('%&',$entidad['idLocalidad']);
                $entidad['idLocalidad'] = $localidad[0];
                if($localidad[1] != $entidad['localidad']){
                    //creamos localidad si no existe
                    $localidad = new Localidad();
                    $localidad->localidad = $entidad['localidad'];
                    $localidad->Add($localidad);
                    $entidad['idLocalidad'] = $localidad->GetLastId();
                    if($entidad['idLocalidad'] == 0){
                        $entidad['idLocalidad'] = $localidad->FindByField('localidad',$localidad->localidad)[0]['idLocalidad'];
                    }
                }

                $this->entity->setAttribute($entidad);
                $this->entity->Edit($this->entity);                
            }
            else{
                $this->setViewBag();
                $this->viewBag->error = 'La contraseña proporcionada es incorrecta';
            }
            $id = isset($entidad['id'])?$entidad['id']:0;
            return $this->Index($entidad, $id);
        }

        public function RedirectToAction(array $http){
            if(isset($http['accion'])){
                switch($http['accion']){
                    case "Edit":
                        $this->Edit($http);
                    break;
                    default:
                    return $this->Index();                                     
                }
                                
            }
            else  if(isset($_GET['id']) && is_numeric($_GET['id'])){
                $this->Index(null, $_GET['id']);
            }
            else {
                $this->Index();
            }
            
        }
  
    }
    $obj = new PerfilController();
    $obj->RedirectToAction($_REQUEST);  
   
?>