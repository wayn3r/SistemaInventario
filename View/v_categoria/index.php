
    <div class="jumbotron ml-2 mr-2 overflow-auto">
        <h1 class="display-4">Categoria</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Categoria</li>
        </ol>
    </nav>
    </div>
    <main class="w-100">
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
                                <a href="categoria.php?id={$row->idCategoria}" id="ancla-{$row->idCategoria}">{$row->categoria}</a>
                                <div>
                                    <a href="#edit-ctg-{$row->idCategoria}" data-toggle="collapse" aria-expanded="false" aria-controls="edit-ctg"
                                    class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                                    <a href="#remove-modal" data-id='{$row->idCategoria}' data-titulo='{$row->categoria}' class="badge badge-pill btn-outline-danger" data-toggle="modal"><span class="">Eliminar</span></a>
                                </div>
                                </div>
                                <div class="collapse w-100 justify-content-center" id="edit-ctg-{$row->idCategoria}">
                                    <label for="categoria-edit" class="">Modificar categoria</label>
                                        <form action="categoria.php" method="post" class="input-group">
                                            <input required type="text" class="form-control input-group-prepend" id="categoria-edit" name="categoria" placeholder="Introduzca nuevo nombre" value="{$row->categoria}">
                                            <input required type="text" id="id-edit" name="idCategoria" value="{$row->idCategoria}" hidden>
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
              <a href="#add-ctg" class="m-3" data-toggle="collapse" aria-expanded="false" aria-controls="add-ctg">Agregar categoria</a>
          </div>

          <div class="collapse" id="add-ctg">
              <div class="card card-body">
                  <label for="categoria" class="">Nueva categoria</label>
                  <form action="categoria.php" class="input-group" method="post">
                      <input required type="text" class="form-control" id="categoria" name="categoria" placeholder="Introduzca nueva categoria">
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
                        Para eliminar una categoria se deben eliminar todos sus elementos.
                        ¿Deseas continuar?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="categoria.php" method="post">
                            <input required type="text" id="id-remove" name="id" hidden/>
                            <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
