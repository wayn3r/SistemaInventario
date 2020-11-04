<main class="w-100">
    <div class="jumbotron ml-2 mr-2">
        <h1 class="display-4">Correo</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Correo</li>
        </ol>
    </nav>
    </div>
      <div class="container">
          <div class="alert alert-light border-left">
              <span class="text-muted">A estas direcciones de correo, se reenviarán los reporte al tener seleccionada la opción enviar al correo.</span>
          </div>
          <div class="row">
              <a href="entrega.php" class="ml-3">&laquo; Volver a la lista de entregas</a>
          </div>
          <ul class="list-group mt-3">
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
                               <div class="btn container-fluid d-flex flex-wrap justify-content-between ">
                                <span>{$row->correo}</span>
                                <div class="ml-auto">
                                    <a href="#edit-ctg-{$row->idCorreo}" data-toggle="collapse" aria-expanded="false" aria-controls="edit-ctg"
                                    class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                                    <a href="#remove-modal" data-id='{$row->idCorreo}' data-titulo='{$row->correo}' class="badge badge-pill btn-outline-danger" data-toggle="modal"><span class="">Eliminar</span></a>
                                </div>
                                </div>
                                <div class="collapse w-100 justify-content-center mt-2 p-2 border-top" id="edit-ctg-{$row->idCorreo}">
                                    <label for="correo-edit" class="">Modificar correo</label>
                                        <form action="correo.php" method="post" class="input-group">
                                            <input required type="email" class="form-control input-group-prepend" id="correo-edit" name="correo" placeholder="Introduzca nuevo nombre" value="{$row->correo}">
                                            <input required type="text" id="id-edit" name="idCorreo" value="{$row->idCorreo}" hidden>
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
              <a href="#add-mail" class="m-3" data-toggle="collapse" aria-expanded="false" aria-controls="add-mail">Agregar correo</a>
          </div>

          <div class="collapse" id="add-mail">
              <div class="card card-body">
                  <label for="correo" class="">Nueva dirección de correo</label>
                  <form action="correo.php" class="input-group" method="post">
                      <input required type="email" class="form-control" id="correo" name="correo" placeholder="Introduzca nuevo correo electrónico">
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
                        Esta a punto de eliminar este correo electrónico.
                        ¿Deseas continuar?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="correo.php" method="post">
                            <input required type="text" id="id-remove" name="id" hidden/>
                            <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>