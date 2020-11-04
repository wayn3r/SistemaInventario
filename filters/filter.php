<?php
namespace filter;

require_once('../filters/sesion.php');
class Filter{
    public $freeAccess;
    public $onlyAdmin;
    public $sesion;
    public function __construct()
    {
        $this->freeAccess = ['home'];
        $this->onlyAdmin = ['administracion','rol'];
        $this->sesion = session::GetSession();
    }

    public function Filtrar(){
        $site = $this->GetSite();
        $controller = explode('.php',$site[count($site) - 1]);
        $controller = $controller[0];

        //comprobando otras formas de acceso
        $free = array_search($controller,$this->freeAccess);
        $admin = array_search($controller,$this->onlyAdmin);
        $admin = is_bool($admin) || $this->sesion->IsAdmin();

        //------- verificar que este en controler
        // $isController = $site[count($site) - 2] === 'Controller';
        // if(!$isController){
        //     header('location:../Controller/');
        // }
        //---------

        $hasAccess = $this->sesion->HasAccess($controller);
        if(!$hasAccess){
            $allowed = false; 

            if(!is_bool($free)){
              $allowed = true;            
            }

        }else{
            $allowed = true;

            if(!$admin){
                $allowed = false; 
            }
        }
        
        if(!$allowed){
            header('location:home.php?accion=Error');
        }
    }

    private function GetSite():array{
        $site = explode('/',$_SERVER['REQUEST_URI']);
        return $site;
    }
}

?>