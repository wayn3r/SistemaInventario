<?php
    namespace Controller;
    require_once('../Model/m_usuario.php');
    require_once('../Model/m_perfil.php');
    require_once('../Model/m_localidad.php');
    require_once('../Model/m_departamento.php');
    require_once('../Model/mensajero.php');
    require_once('../filters/sesion.php');
    require_once('../Controller/_controller.php');

use Email;
use filter\session;
use Model\db\entity;
use Model\Departamento;
use Model\Localidad;
use Model\Perfil;
use Model\Usuario;

class HomeController extends Controller{

        public function __construct(){
            $this->entity = new Usuario();
            $this->viewEntity = new Perfil();
            $this->viewName = 'v_home';
            $this->title = 'Home';
            $this->subscribe();
            $this->sesion = session::GetSession();
        }

        public function Index(){
            $this->setViewBag();
            $this->getData();
            $this->getView('index', false);
            
        }
        


        public function update($info)
        {
            $this->result = new \stdClass;
            $this->result->duplicate = false;
            if(substr($info->error,0,9) == 'Duplicate'){
                $this->result->duplicate = true;
            }
            $this->result->noshow = true;
        }

        public function Log(array $login = null)
        {
            $this->setViewBag();
            if(isset($login)){
                $user = $this->entity->FindByField('user',$login['user']);
                if(!isset($user[0])){
                    $this->viewBag->login = $login;
                    $this->viewBag->login['error']['user'] = 'Usuario inexistente';
                    return $this->getView('login', false,false);
                }
                
                $user = $user[0]; 
                if(strtolower($user['user']) === strtolower($login['user']) && $user['pass'] === md5($login['pass'])){
                    $session = session::GetSession();
                    $session->SetUser($user);
                    return $this->Index();
                }
                else{
                    $this->viewBag->login = $login;
                    $this->viewBag->login['error']['pass'] = 'Contraseña incorrecta';
                    return $this->getView('login', false);
                }

            }
                
            return $this->getView('login', false);

        }
        public function Logout(){
            $this->sesion->CloseSession();
            $this->Log();
        }
        public function Error(){
            return $this->getView('error',false,false);
        }
        public function Password(array $usuario = null){
            $this->setViewBag();
            if(isset($usuario['user'])){
                $this->viewBag->user = $usuario['user'];
                $user = $this->entity->FindByField('user',$usuario['user']);
                $perfil = count($user)<1?$this->viewEntity->FindByField('correo',$usuario['user']):$this->viewEntity->FindByField('idPerfil',$user[0]['idPerfil']);
                if(count($perfil) < 1){
                    $this->viewBag->error = 'Este nombre de usuario no existe';
                    return $this->getView('password',false,false);
                }
                $user = count($user)<1?$this->entity->FindByField('idPerfil',$perfil[0]['idPerfil']):$user;
                $user = $user[0];
                $perfil = $perfil[0];
                $correo = $perfil['correo'];
                $token = $user['pass'];
                $mail = new Email();
                //obteniendo la direccion del servidor servidor
                require_once('../Model/functions.php');
                $server = getServerAddress();

                $mensaje =<<<input
                    <h1>Buenas, {$perfil['nombre']}!</h1>
                    <p>Hemos recibido tu pedición para reestablecer tu contraseña. Para continuar haz <a href="{$server}/home.php?accion=Reset&id={$user['idUsuario']}&token={$token}">click aquí</a>.</p>
                input;
                $mail->SetMessage($correo,'Reestablecer contraseña',$mensaje);
                $mail->SendMessage();
                $this->viewBag->mail = $correo;
            }
            return $this->getView('password',false,false);
        }
        public function Reset(array $usuario = null){
            $this->setViewBag();
            if(isset($usuario['error']))
                $this->viewBag->error = $usuario['error'];
            if(isset($usuario['token']) && !isset($usuario['reset'])){
                try{
                    $user = $this->entity->Find($usuario['id']);
                    $token = $usuario['token'];
                    if(isset($user[0]) && $user[0]['pass'] === $token){
                        $this->viewBag->data = $user[0];
                        return $this->getView('reset',false,false);
                    }
                }catch(\Exception $e){}
            }
            else if(isset($usuario['pass']) && isset($usuario['reset'])){
                try{
                    $user = $this->entity->Find($usuario['id'])[0];
                    $autorizado = $user['pass'] === $usuario['token'];
                    if($autorizado ){
                        if($usuario['pass'] === $usuario['pass2']){
                            $this->entity->setAttribute($user);
                            $this->entity->pass = md5($usuario['pass']);
                            $this->entity->Edit($this->entity);
                            return $this->RedirectToAction([]);
                        }
                        else{

                            $usuario['error'] = 'Las contraseñas deben coincidir'; 
                        }
                    }
                }catch(\Exception $e){}
                unset($usuario['reset']);
                return $this->Reset($usuario);
            }
            return $this->RedirectToAction([]);
        }
        public function RedirectToAction(array $http)
        {
            if(isset($http['accion'])){
                switch($http['accion']){
                    case "Login":
                        $this->Log($http);
                    break;
                    case "Logout":
                        $this->Logout();
                    break;
                    case "Error":
                        $this->Error();
                    break;
                    case "Pass":
                        $this->Password($http);
                    break;
                    case "Reset":
                        $this->Reset($http);
                    break;
                    default:
                        $user = $this->sesion->GetUser();
                        if(isset($user))
                            $this->Index();
                        else
                            $this->Log();
                    break;
                                     
                }
                                
            }
            else {
                $user = $this->sesion->GetUser();
                if(isset($user))
                    $this->Index();
                else
                    $this->Log();
            }
        }
       
    }
    
    $obj = new HomeController();
    $obj->RedirectToAction($_REQUEST);
       
    

   
?>