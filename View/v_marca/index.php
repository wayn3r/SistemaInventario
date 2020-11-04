
    <div class="jumbotron">
        <h1 class="display-4">Marca</h1>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Marcas</li>
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
            else
            foreach($this->viewBag->data as $row){
                echo <<<input
                    <li class="list-group-item ">
                       <div class="btn container-fluid d-flex flex-wrap justify-content-between">
                        <a href="marca.php?id={$row->idMarca}">{$row->marca}</a>
                        <div>
                            <a href="#edit-marca-{$row->idMarca}" data-toggle="collapse" aria-expanded="false" aria-controls="edit-marca"
                            class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                            <a href="#remove-modal" data-titulo='{$row->marca}' data-id='{$row->idMarca}' class="badge badge-pill btn-outline-danger" data-toggle="modal"><span class="">Eliminar</span></a>
                        </div>
                        </div>
                        <div class="collapse w-100" id="edit-marca-{$row->idMarca}">
                            <label for="marca-edit" class="">Modificar marca</label>
                                <form action="marca.php" method="post" class="input-group">
                                    <input required type="text" class="form-control input-group-prepend" id="marca-edit" name="marca" placeholder="Introduzca nuevo nombre" value="{$row->marca}">
                                    <input required type="text" id="id-edit" name="idMarca" value="{$row->idMarca}" hidden>
                                    <div class="input-group-append">
                                        <button type="submit" value="Edit" name="accion" class="btn btn-outline-success ">Guardar</button>
                                    </div>
                                </form>
                        </div>
                    </li>
                    
                input;
            }
      ?>
     
  </ul>
  <div class="row justify-content-end">
      <a href="#add-marca" class="m-3" data-toggle="collapse" aria-expanded="false" aria-controls="add-marca">Agregar marca</a>
  </div>

  <div class="collapse" id="add-marca">
      <div class="card card-body">
          <label for="marca" class="">Nueva marca</label>
          <form action="marca.php" class="input-group" method="post">
              <input required type="text" class="form-control" id="marca" name="marca" placeholder="Introduzca nueva marca">
                <div class="input-group-append">
                  <button type="submit" value="Add" name="accion" class="btn btn-outline-success ">Agregar</button>
              </div>
          </form>
      </div>
  </div>
</div>
</main>
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
                Al eliminar una marca, a todos sus articulos se les asigna una marca generica de forma automática.
                ¿Deseas continuar?
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <form action="marca.php" method="post">
                    <input required type="text" id="id-remove" name="id" hidden>
                    <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>