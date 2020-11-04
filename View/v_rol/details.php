<?php

    // use filter\Filter;
    // require_once('../../filters/filter.php');
    // $filter = new Filter;
    // $filter->Filtrar();
    
    $rol = trim($this->viewBag->data[0]->rol,'s,es');
    $rol = strtolower($rol);
?>
<main class="col-12">
   <div class="jumbotron ml-2 mr-2">

<h1 class="display-4">
    <?=ucfirst($rol);?>
</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="home.php">Home</a></li>
            <li class="breadcrumb-item "><a href="administracion.php">Administración</a></li>
            <li class="breadcrumb-item "><a href="rol.php">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=ucfirst($rol);?></li>
        </ol>
    </nav>
</div>
<div class="container">
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th scope="col">Controlador</th>
            <th scope="col">Página asociada</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>    
      <?php
            if($this->viewBag->children[0]->controlador == null){
                echo<<<input
                    <tr scope="row" >
                        <td scope="col" colspan="3" class="text-center">
                            <span class="display-4 text-muted">No existen permisos</span>
                        </td>
                    </tr>
                input;
            }
            else{
                require_once('../Model/functions.php');
                $server = getServerAddress();
            foreach($this->viewBag->children as $row){
                
                echo <<<input
                    <tr scope="row">
                        <td scope="col">
                           {$row->controlador}
                        </td>
                        <td scope="col">
                            {$server}/{$row->pagina}
                        </td>
                        <td scope="col">
                            <a href="rol_acceso.php?fv=rol&id={$this->viewBag->data[0]->idRol}&accion=Remove&idR={$row->idRol}&idA={$row->idAcceso}" class="badge badge-pill btn-outline-danger">Eliminar</a>
                        </td>
                    </tr>                    
                input;
            }
            }
      ?>
     </tbody>
  </table>
</div>

  <div class="row justify-content-end">
      <a href="#add-ctg" class="m-3" data-toggle="collapse" aria-expanded="false" aria-controls="add-ctg">Agregar acceso</a>
  </div>

  <div class="collapse" id="add-ctg">
      <div class="card card-body">
          <label for="">Nuevo acceso:</label>
          <form action="rol_acceso.php?fv=rol&id=<?=$this->viewBag->data[0]->idRol?>" class="input-group " method="post">
            <select class="custom-select" name="idAcceso" value="" required>
            <option value="">Introduzca nuevo acceso para <?=$rol?></option>
            <?php if(isset($this->viewBag->accesos)){
                foreach($this->viewBag->accesos as $row){?>
                <option value="<?=$row->idAcceso?>" ><?=$row->controlador?></option>
            <?php }}?>
            </select>
              <input required type="text" value="<?=$this->viewBag->data[0]->idRol?>" name = "idRol" hidden>
            <div class="input-group-append">
                <button type="submit" value="Add" name="accion" class="btn btn-outline-success ">Agregar</button>
            </div>
          </form>
      </div>
  </div>
</div>

</main>
<!-- MODAL PARA ELIMINAR TIPOS DE ARTICULOS -->
<div class="modal fade" id="remove-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Eliminar -</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Estas a punto de eliminar este acceso.
                ¿Deseas continuar?
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <form action="tipoArticulo.php?fv=rol&id=<?=$this->viewBag->data[0]->idRol;?>" method="post">
                    <input required type="text" id="id-remove" name="id" hidden >
                    <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>


