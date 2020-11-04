<?php
require_once('../filters/filter.php');
use filter\Filter;
use filter\session;

ob_start();
    $filter = new Filter;
    $filter->Filtrar();
    $fv = explode('/',$_SERVER['REQUEST_URI']);
    $fv= array_pop($fv);
    $fv=str_replace('.php','',$fv);
    $fv=str_replace('?','&',$fv);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1.0, minimum-scale=1.0">
    <title>Ron Barceló - <?=isset($this->title) ? $this->title : 'Sistema Inventario'?></title>
    <link rel="stylesheet" href="../utils/css/bootstrap.min.css">
    <link rel="stylesheet" href="../utils/css/Chart.min.css">
    <link rel="stylesheet" href="../utils/css/customcss.css">
</head>
<body>        
<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-between sticky-top ">
    <!-- MARCA-->
    <a href="home.php" class="navbar-brand ml-5">Ron Barceló</a>  

<?php 
    $sesion = session::GetSession();
    $user = $sesion->GetUser();
    if(isset($user)){ 
?>
<!-- OBTENIENDO NOTIFICACIONES -->
<?php
    $count = 0;
    $nots = '';
    if(isset($this->viewBag->notificaciones))
    foreach($this->viewBag->notificaciones as $not){
        $bg_color = 'alert-info';
        $link = '';
        require_once('../Model/functions.php');
        $not->fecha = setTime($not->fecha);
        if($not->visto == '1'){
            $bg_color ='alert-secondary';
        }
        else{
            $link = "<div class='col-7 text-right'><a href='notificacion.php?fv={$fv}&accion=Edit&idNotificacion={$not->idNotificacion}' class='text-reset'>Marcar como leido</a></div>";
            $count++;
        }
        $nots.=<<<input
            <div class="row m-1 p-1 d-flex justify-content-between border-top {$bg_color} " >
                <div class="col-11">
                    <p>{$not->mensaje}</p> 
                    <span>{$not->infoAdicional}</span> 
                </div>
                <div class='col-1 text-center'>
                    <span class="row text-right align-middle badge btn-outline-danger ">
                        <a href='notificacion.php?fv={$fv}&accion=Remove&idNot={$not->idNotificacion}' class="text-reset text-decoration-none ">&times;</a>
                    </span>
                </div>
                <div class="col-5"><small class="text-muted">{$not->fecha}</small></div>
                {$link}
            </div>
        input;
    }
?>
    <!-- BOTON COLLAPSE-->    
    <button 
    data-toggle="collapse" data-expanded="false" data-target="#nav-content" aria-controls="nav-content" class="navbar-toggler btn btn-dark" >
        <span class="navbar-toggler-icon"></span>
    </button>

        <!-- CONTENIDO-->
    <div class="navbar-collapse collapse flex-grow-0 justify-content-end" id="nav-content">
        <ul class="navbar-nav justify-content-end text-right">
            <?php 
                $isAdmin = $sesion->IsAdmin();
                if($isAdmin){
            ?>
            <li class="nav-item"> 
                <a href="administracion.php" class="nav-link text-white">Administración</a>
            </li>
            <?php }?>
            <li class="nav-item " >
                <div class="dropdown show " >
                    <a class="dropdown-toggle nav-link text-white" role="button"                 
                    id="dropdownNotificaciones" data-toggle="dropdown" 
                    aria-haspopup="true" aria-expanded="false">
                        &#x1f56d;
                        Notificaciones
                        <span class="badge bg-danger text-white" <?=($count < 1 ? 'hidden':'')?>><?=$count?></span>
                    </a>
                    
                    <div class="row dropdown-menu dropdown-menu-clickable dropdown-menu-right" 
                    aria-labelledby="dropdownNotificaciones" role='menu' style="position:absolute; max-width:90vw; max-height:70vh; width:400px; overflow-y:auto;">
                        <div class="pl-2 p-1 rounded d-flex justify-content-between">
                            <span class="h5 col-4">
                                Notificaciones
                            </span>
                            <span class="col-5 col-lg-4 text-right">
                                <a href='notificacion.php?fv=<?=$fv?>&accion=Edit&idNotificacion=all' class="text-muted" <?=($count < 1 ? 'hidden':'')?>>Marcar todo</a>
                            </span>
                        </div>
                        <?=($nots?:"<p class='text-muted p-3'>La bandaja de notificaciones esta vacia</p>")?>
                    </div>
                </div>
            </li>
            <li class="nav-item"> 
                <a href="entrega.php" class="nav-link text-white">Entregas</a>
            </li>
            <li class="nav-item"> 
                <a href="reporte.php" class="nav-link text-white">Reportes</a>
            </li>
            <li class="nav-item"> 
                <div class="dropdown show">
                    <a class="dropdown-toggle nav-link text-white" role="button"                 
                    id="dropdownControles" data-toggle="dropdown" 
                    aria-haspopup="true" aria-expanded="false">
                        Inventario
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" style="position:absolute;" aria-labelledby="dropdownControles">
                        <a href="../Controller/categoria.php" class="dropdown-item">Categorias</a>
                        <a href="../Controller/marca.php" class="dropdown-item">Marcas</a>
                        <a href="../Controller/tipoarticulo.php" class="dropdown-item">Articulos</a>
                        <a href="../Controller/articulo.php" class="dropdown-item">Modelos</a>
                        <a href="../Controller/existencia.php" class="dropdown-item">Existencias</a>
                        <div class="dropdown-divider"></div>
                        <a href="../Controller/impresora.php" class="dropdown-item">Impresoras</a>
                    </div>
                </div>
            </li>
            <li class="nav-item"> 
                <div class="dropdown show">
                    <a class="dropdown-toggle nav-link text-white" role="button"                 
                    id="dropdownPerfil" data-toggle="dropdown" 
                    aria-haspopup="true" aria-expanded="false">
                        &#9881;&#65039; Perfil
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" style="position:absolute;" aria-labelledby="dropdownPerfil">
                        <a href="usuario.php" class="dropdown-item">Mi cuenta</a>
                        <a href="perfil.php" class="dropdown-item">Mi perfil</a>
                        <div class="dropdown-divider"></div>
                        <a href="home.php?accion=Logout" class="dropdown-item">Cerrar sesión</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
<?php } ?>
</nav>    
<div class="row no-gutters justify-content-between main-content mt-1">