
<main class="col-12">
   <div class="jumbotron ml-2 mr-2">
        <h1 class="display-4">Roles</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item "><a href="home.php">Home</a></li>
            <li class="breadcrumb-item "><a href="administracion.php">Administración</a></li>
            <li class="breadcrumb-item active" aria-current="page">Roles</li>
        </ol>
    </nav>
    </div>
      <div class="container">
          <ul class="list-group">
          
              <?php
                if($this->viewBag->data == null){
                    echo<<<input
                        <span class="display-3 text-muted text-center">No existen registros</span>
                    input;
                }
                else{
                    foreach($this->viewBag->data as $row){
                        echo <<<input
                            <li class="list-group-item ">
                               <div class="btn container-fluid d-flex flex-wrap justify-content-between">
                                <a href="rol.php?id={$row->idRol}" id="ancla-{$row->idRol}">{$row->rol}</a>
                                <div>
                                    <a href="#edit-ctg-{$row->idRol}" data-toggle="collapse" aria-expanded="false" aria-controls="edit-ctg"
                                    class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                                    <a href="#remove-modal" data-id='{$row->idRol}' data-titulo='{$row->rol}' class="badge badge-pill btn-outline-danger" data-toggle="modal"><span class="">Eliminar</span></a>
                                </div>
                                </div>
                                <div class="collapse w-100 justify-content-center" id="edit-ctg-{$row->idRol}">
                                    <label for="rol-edit" class="">Modificar rol</label>
                                        <form action="rol.php" method="post" class="input-group">
                                            <input required type="text" class="form-control input-group-prepend" id="rol-edit" name="rol" placeholder="Introduzca nuevo nombre" value="{$row->rol}">
                                            <input required type="text" id="id-edit" name="idRol" value="{$row->idRol}" hidden>
                                            <div class="input-group-append">
                                                <button type="submit" value="Edit" name="accion" class="btn btn-outline-success ">Guardar</button>
                                            </div>
                                        </form>
                                </div>
                            </li>
                            
                        input;
                    }
                }

              ?>
             
          </ul>
          <div class="row justify-content-end">
              <a href="#add-ctg" class="m-3" data-toggle="collapse" aria-expanded="false" aria-controls="add-ctg">Agregar rol</a>
          </div>

          <div class="collapse" id="add-ctg">
              <div class="card card-body">
                  <label for="rol" class="">Nueva rol</label>
                  <form action="rol.php" class="input-group" method="post">
                      <input required type="text" class="form-control" id="rol" name="rol" placeholder="Introduzca nueva rol">
                          <div class="input-group-append">
                          <button type="submit" value="Add" name="accion" class="btn btn-outline-success ">Agregar</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>

        <div class="modal fade" id="remove-modal" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <form action="rol.php" method="post">
                            <input required type="text" id="id-remove" name="id" hidden/>
                            <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
