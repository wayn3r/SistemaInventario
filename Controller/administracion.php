<?php
    namespace Controller;
    require_once('../Model/m_usuario.php');
    require_once('../Model/m_perfil.php');
    require_once('../Model/m_localidad.php');
    require_once('../Model/m_departamento.php');
    require_once('../Model/m_listingusuario.php');
    require_once('../Model/mensajero.php');
    require_once('../filters/sesion.php');
    require_once('../Controller/_controller.php');

use Email;
use ListingUsuarios;
use Model\Departamento;
use Model\Localidad;
use Model\Perfil;
use Model\Rol;
use Model\Usuario;

class AdministracionController extends Controller{

        public function __construct(){
            $this->entity = new Usuario();
            $this->viewEntity = new ListingUsuarios();
            $this->childEntity = new Perfil();
            $this->viewName = 'v_administracion';
            $this->title = 'Administracion';
            $this->subscribe();
        }
        public function Index()
        {
            return $this->getView('index',false);
        }
        public function Usuario()
        {
            $this->setViewBag();
            $this->getData();
            return $this->getView('usuario');
        }
        public function Signup(array $entidad = null){
            $localidad = new Localidad();
            if(count($entidad)>1){
                if($entidad['pass'] === $entidad['pass2']){
                    $usr = $this->entity->FindByField('user',$entidad['user']);
                    if(count($usr) > 0){
                        $entidad['error']['user'] = 'Este nombre de usuario ya existe, elige otro';
                        goto view;
                    }
                    $pfl = $this->childEntity->FindByField('correo',$entidad['correo']);
                    if(count($pfl) > 0){
                        $entidad['error']['correo'] = 'Este correo electronico esta registrado en otro perfil, introduzca uno diferente';
                        goto view;
                    }
                    
                    //creamos localidad si no existe
                    $localidad->localidad = $entidad['localidad'];
                    $localidad->Add($localidad);
                    $idL = $localidad->GetLastId();
                    if($idL == 0){
                        $idL = $localidad->FindByField('localidad',$localidad->localidad)[0]['idLocalidad'];
                    }

                    // creamos el perfil
                    $this->childEntity->setAttribute($entidad);
                    $this->childEntity->idLocalidad = $idL;
                    $this->childEntity->fechaCreacion = date('Y-m-d');
                    $this->childEntity->Add($this->childEntity);
                    $idP = $this->childEntity->GetLastId();
                    
                    // creamos el usuario
                    $entidad['pass'] = md5($entidad['pass']);//md5 el pass
                    $this->entity->setAttribute($entidad);
                    $this->entity->idPerfil = $idP;
                    $this->entity->Add($this->entity);

                    $this->Index();

                    //enviar mail de bienvenida
                    $mail = new Email();
                    //direccion del servidor
                    require_once('../Model/functions.php');
                    $server = getServerAddress();

                    $mensaje =<<<input
                        <h1>Buenas, {$entidad['nombre']} {$entidad['apellido']}!</h1>
                        <h2>Registro completado</h2>
                        <p>La creacion de su cuenta se ha completado con exito. Inicia sesión en nuestro sitio con este nombre de usuario:<strong>{$entidad['user']}</strong></p>
                        <a class="btn btn-success" href="{$server}/home.php">Ir a la pagina</a>
                    input;
                    $mail->SetMessage($entidad['correo'],'Registro completado',$mensaje);
                    $mail->SendMessage();
 
                }
                else{
                    $entidad['error']['pass'] = 'Las contraseñas deben coincidir';
                    goto view;
                }
            }else{
                view:
                $this->setViewBag();
                $this->viewBag->localidades = $localidad->ReturnList();
                $departamentos = new Departamento();
                $this->viewBag->departamentos = $departamentos->ReturnList();
                $roles = new Rol();
                $this->viewBag->roles = $roles->ReturnList();
                $this->viewBag->registro = $entidad;
                return $this->getView('registro', false,false);
            }
            
        }        

        public function RedirectToAction(array $http)
        {
            if(isset($http['accion'])){
                switch($http['accion']){
                    case "Signup":
                        $this->Signup($http);
                    break;
                    case "User":
                        $this->Usuario($http);
                    break;
                    default:
                    return $this->Index();                                     
                }
                                
            }
            else {
                // $this->entity = $this->sesion->GetUser();
                // if(isset($this->entity))
                    $this->Index();
                // else
                //     $this->Log();
            }
        }
       
    }
    
    $obj = new AdministracionController();
    $obj->RedirectToAction($_REQUEST);
   
?>