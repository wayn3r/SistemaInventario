<?php
namespace filter;

use Model\Acceso;
use Model\ListingAcceso;
use Model\Rol;
use Model\Usuario;

require_once('../Model/m_usuario.php');
require_once('../Model/m_rol.php');
require_once('../Model/m_listingacceso.php');
    class session{

        private static $instance;
        private function __construct(){
            
            if(!isset($_SESSION))
                session_start();
        }
        
        public static function GetSession(){
            if(self::$instance == null)
                self::$instance = new session();
            
            return self::$instance;
        }
        public function SetUser(array $user){
            $usr = new Usuario();
            $usr->setAttribute($user);
            $_SESSION['user'] = $usr;

            $this->SetRol($usr->idRol);

            $this->SetAccess($usr->idRol);
            
        }
        public function GetUser(){
            if(isset($_SESSION['user']))
                return $_SESSION['user'];            
            
        }

        private function SetRol(int $idRol){
            $rol = new Rol();
            $rol = $rol->setAttribute($rol->Find($idRol)[0]);
            
            $_SESSION['rol'] = $rol;
        }

        private function SetAccess(int $idRol){
            $accesos = new ListingAcceso();
            $accesos = $accesos->Find($idRol);

            foreach($accesos as $acceso){
                $page = explode('.php',$acceso['pagina'])[0];
                $_SESSION['access'][$acceso['controlador']] = $page;
            }
        }
        public function GetRol(){
            if(isset($_SESSION['rol']))
                return $_SESSION['rol'];
        }
        public function IsAdmin():bool
        {
            $rol = strtolower($_SESSION['rol']->rol);
            $isAdmin = $rol === 'admin' || $rol === 'administrador'; 
            return $isAdmin;
        }
        public function HasAccess(string $page):bool{
            $access = false;
            if(isset($_SESSION['user']) && isset($_SESSION['access'])){
                $page = explode('.php',$page)[0];
                $access = array_search($page,$_SESSION['access']);
                if(!is_bool($access))
                    $access = true;
                else if(isset($_SESSION['access']['Todos']))
                    $access = true;
            }

            return $access;
        }

        public function CloseSession(){
            self::getSession();
            session_unset();
            session_destroy();
        }
    }
?>