<main class="w-100">
<div class="jumbotron ml-2 mr-2 overflow-auto">
    <h1 class="display-4">
       Empleados
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Empleados</li>
        </ol>
    </nav>
</div>
<div class="container w-75">
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th scope="col">Codigo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Correo electrónico</th>
            <th scope="col">Fecha de Entrada</th>
            <th scope="col">Estado</th>
            <th scope="col">Departamento</th>
            <th></th>
        </tr>
    </thead>
    <tbody>    
      <?php
      $departamentos = '';
       if(isset($this->viewBag->departamentos)){ 
           foreach($this->viewBag->departamentos as $row){
                $departamentos.=<<<input
                    <option value="{$row->idDepartamento}">{$row->departamento}</option>
                input;
           }
        }
            if($this->viewBag->data != null){
                foreach($this->viewBag->data as $row){?>
                    <tr scope="row">
                        <td scope="col">
                            <?=$row->codigoEmpleado?>
                        </td>
                        <td scope="col">
                            <?=$row->nombre?>
                        </td>
                        <td scope="col">
                           <?=$row->apellido?>
                        </td>
                        <td scope="col">
                           <?=$row->correo?>
                        </td>
                        <td scope="col">
                           <?=$row->fechaEntrada?>
                        </td>
                        <td scope="col">
                            <?=($row->activo == 1)?'Activo':'Inactivo'?>
                        </td>
                        <td scope="col">
                            <?=$row->departamento?>
                        </td>
                        <td scope="col">
                            <a href="#edit-modal-<?=$row->idEmpleado?>" data-toggle="modal" class="badge badge-pill btn-outline-info ">Editar</a>
                            <a href="empleado.php?id=<?=$row->idEmpleado?>&accion=Remove" class="badge badge-pill btn-outline-danger">Eliminar</a>
                        </td>
                    </tr>                    
                  <!-- MODAL EDITAR -->
                <div class="modal fade" id="edit-modal-<?=$row->idEmpleado?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">Editar empleado - <?=$row->nombre?></h3>
                                <button class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form action="empleado.php" class="form-group" method="post">
                                <input type="text" hidden value="<?=$row->idEmpleado?>" required name="idEmpleado">
                                    <div class="form-group">
                                        <label for="codigoEmpleado">Codigo Empleado:</label>
                                        <input required name="codigoEmpleado" id="codigoEmpleado" class="form-control" placeholder="Escribe el codigo del empleado" value="<?=$row->codigoEmpleado?>">                       
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombe:</label>
                                        <input required name="nombre" id="nombre" class="form-control" placeholder="Escribe el nombre del empleado" value="<?=$row->nombre?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido:</label>
                                        <input required type="text" name="apellido" id="apellido" class="form-control" placeholder="Escribe el apellido del empleado" value="<?=$row->apellido?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">Correo electrónico:</label>
                                        <input required type="email" name="correo" id="correo" class="form-control" placeholder="Escribe el correo electronico del empleado" value="<?=$row->correo?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="estado">Estado:</label>
                                        <select required name="activo" id="estado" class="form-control" >
                                            <option value="">Selecciona el estado del empleado</option>
                                            <option value="1" <?=($row->activo == 1)?'selected':''?> >Activo</option>
                                            <option value="0" <?=($row->activo == 0)?'selected':''?>>Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="form-group" >
                                        <label for="idDepartamento">Departamento:</label>
                                        <select type="text" name="idDepartamento" class="custom-select" required >
                                            <option value="">Selecciona el departamento del empleado</option>
                                            <?=$departamentos?>
                                            <option value="<?=$row->idDepartamento?>" selected hidden><?=$row->departamento?></option>
                                        </select>
                                    </div>

                            </div>
                            <div class="modal-footer">
                                    <button class="btn btn-success" value="Edit" type="submit" name="accion">Aceptar</button>
                                    <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                                </form>
                            </div>            
                        </div>
                    </div>
                </div>
              <?php  }}else{?>
                    <tr scope="row" >
                        <td scope="col" colspan="4" class="text-center">
                            <span class="display-4 text-muted">No existen registros</span>
                        </td>
                    </tr>
          <?php }
      ?>
     </tbody>
  </table>

  <div class="d-flex justify-content-end"><a href="#add-modal" data-toggle="modal">Agregar empleado</a></div>
</div>
</div>
</main>
<!-- MODAL AGREGAR -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar empleado</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form action="empleado.php" class="form-group" method="post">
                    <div class="form-group">
                        <label for="codigoEmpleado">Codigo Empleado:</label>
                        <input required name="codigoEmpleado" id="codigoEmpleado" class="form-control" placeholder="Escribe el codigo del empleado">                       
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombe:</label>
                        <input required name="nombre" id="nombre" class="form-control" placeholder="Escribe el nombre del empleado">
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input required type="text" name="apellido" id="apellido" class="form-control" placeholder="Escribe el apellido del empleado">
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo electrónico:</label>
                        <input required type="email" name="correo" id="correo" class="form-control" placeholder="Escribe el correo electronico del empleado">
                    </div>
                    <div class="form-group" >
                        <label for="idDepartamento">Departamento:</label>
                        <select type="text" name="idDepartamento" class="custom-select" required >
                            <option value="">Selecciona el departamento del empleado</option>
                            <?=$departamentos?>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                    <button class="btn btn-success" value="Add" type="submit" name="accion">Aceptar</button>
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>            
        </div>
    </div>
</div>