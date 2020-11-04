<?php
    namespace Controller;
    require_once('../Model/m_usuario.php');
    require_once('../Model/m_rol.php');
    require_once('../Model/m_listingusuario.php');
    require_once('../Model/m_perfil.php');
    require_once('../Model/mensajero.php');
    require_once('../Controller/_controller.php');

use Email;
use filter\session;
use ListingUsuarios;
use Model\db\entity;
use Model\Perfil;
use Model\Rol;
use Model\Usuario;

class UsuarioController extends Controller{

        public function __construct(){
            $this->entity = new Usuario();
            $this->viewEntity = new ListingUsuarios();
            $this->viewName = 'v_usuario';
            $this->title = 'Usuario';
            $this->sesion = session::GetSession();
            $this->subscribe();
        }
        public function Index(int $id = 0){
            $this->setViewBag();
            if($id > 0 && $this->sesion->IsAdmin()){
                $idUsuario = $id;
                //buscando roles para los admins
                $rol = new Rol();
                $this->viewBag->roles = $rol->ReturnList();
            }else{
                $user = $this->sesion->GetUser();          
                $idUsuario = $user->idUsuario;
            }
            $this->viewBag->data = $this->viewEntity->Find($idUsuario);
            $this->viewBag->data[0]['id'] = $id;

            $this->getView('index');            
        }
        
        public function Edit(array $entidad){

            $id = isset($entidad['id'])?$entidad['id']:0;
            $user = $this->sesion->GetUser(); 
            $autorizado = $user->pass === md5($entidad['pass-gc']);
            $this->setViewBag();
            if($autorizado) {                
                if(isset($entidad['user'])){
                    $this->entity->setAttribute($entidad);
                    if(!isset($entidad['idRol']) || !$this->sesion->IsAdmin())
                        $this->entity->idRol = $user->idRol;

                    $this->entity->Edit($this->entity);
                }
                else if(isset($entidad['pass']) && $entidad['pass'] === $entidad['pass2']){
                    $this->entity->pass = md5($entidad['pass']);
                    $this->entity->EditFields('pass',$this->entity->pass,'',$entidad['idUsuario']);

                    $this->Index($id);

                    //buscando el perfil
                    $perfil = new Perfil();
                    $perfil = $perfil->Find($user->idPerfil)[0];
                     //enviar mail de cambio de contraseña
                     $mail = new Email();
                     //direccion del servidor
                     require_once('../Model/functions.php');
                     $server = getServerAddress();
 
                     $mensaje =<<<input
                         <h1>Cambio de contraseña</h1>
                         <p>Se ha modificado su contraseña, si has sido tú puedes ignorar este mensaje. Si no has sido tú le recomendamos cambiar su contraseña por una más segura, haciendo <a href="{$server}/home.php?accion=Reset&id={$user->idUsuario}&token={$this->entity->pass}">click aquí</a></p>
                     input;
                     $mail->SetMessage($perfil['correo'],'Cambio de contraseña',$mensaje);
                     $mail->SendMessage();
 
                }
                else{
                    $this->viewBag->error = 'La contraseñas no coinciden';
                }
                //-------volviendo a logear-------------
                if($user->idUsuario === $entidad['idUsuario']){
                    $this->sesion->SetUser($this->entity->Find($user->idUsuario)[0]);
                }
            }
            else{
                $this->viewBag->error = 'La contraseña proporcionada es incorrecta';
            }

            return $this->Index($id);

        }
        public function Remove(int $id, $pass=null){
            $user = $this->sesion->GetUser();
            if($pass != null && md5($pass) === $user->pass){
                $this->entity->Remove($id);
                //buscando el perfil
                $perfil = new Perfil();
                $perfil = $perfil->Find($user->idPerfil)[0];
                 //enviar mail de eliminacion de cuenta de usuario
                 $mail = new Email();
                 $mensaje =<<<input
                     <h1>Cuenta eliminarda</h1>
                     <p>Su cuenta se ha eliminado correctamente, este correo no podra volver ser utilizado para registrarse en nuestra pagina. Si es necesario volver a registrarse utilice otro o comuniquese con los administradores de la pagina.</p>
                 input;
                 $mail->SetMessage($perfil['correo'],'Cuenta eliminada',$mensaje);
                 $mail->SendMessage();
                 if($this->sesion->IsAdmin()){
                    $page = 'administracion';
                    if($id === $user->idUsuario){
                        $this->sesion->CloseSession();
                        $page = 'home';
                    }
                 }else{
                    $this->sesion->CloseSession();
                    $page = 'home';
                 }
                return $this->RedirectToView(['fv'=>$page],$_COOKIE);
            }
            else{
                $this->setViewBag();
                $this->viewBag->error = 'La contraseña proporcionada es incorrecta';
                return $this->Index();
            }
            
        }
        public function RedirectToAction(array $http)
        {
            if(isset($http['accion'])){
                switch($http['accion']){
                    case "Add":
                        $this->Add($http);
                    break;
                    case "Edit":
                        $this->Edit($http);
                    break;
                    case "Remove":
                        try{
                            if(isset($http['id']) && isset($http['pass']) && is_numeric($http['id'])){
                                $this->Remove($http['id'],$http['pass']);
                            }
                        }catch(\Exception $e){}      
                    break;
                    default:
                    return $this->Index();                                     
                }
                                
            }else if(isset($http['id']) && is_numeric($http['id'])){
                return $this->Index($http['id']);
            }
            return $this->Index();
        }
    }
    $obj = new UsuarioController();
    $obj->RedirectToAction($_REQUEST);  
   
?>