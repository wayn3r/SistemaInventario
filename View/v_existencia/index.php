
<div class="jumbotron">
    
    <h1 class="display-4">
    Existencias
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="categoria.php">Categoria</a></li>
            <li class="breadcrumb-item"><a href="tipoarticulo.php">Tipo de articulos</a></li>
            <li class="breadcrumb-item"><a href="articulo.php">Articulos</a></li>
            <li class="breadcrumb-item active" aria-current="page">Existencias</li>
        </ol>
    </nav>

</div>
<main class="w-100">
<div class="container">
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th scope="col">Modelo</th>
            <th scope="col">Estado</th>
            <th scope="col">Marca</th>
            <th scope="col">Articulo</th>
            <th scope="col">Fecha Inventario</th>
            <th scope="col">Fecha Compra</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    
    <?php
            $estados = '';
            if($this->viewBag->estados != null)
            foreach($this->viewBag->estados as $estado){
                $estados .= "<option value = '{$estado->idEstado}'>{$estado->estado}</option>";
            }

            $opciones ='';
            if($this->viewBag->articulos != null){
                foreach($this->viewBag->articulos as $articulo){
                    $opciones .="<option value='{$articulo->idArticulo}'>{$articulo->modelo}</option>";
                }
            }
         if($this->viewBag->data == null){
            echo<<<input
                <tr scope="row">
                    <td scope="col" colspan="8" class="text-center">
                        <span class="display-4 text-muted ">No existen registros</span>
                    </td>
                </tr>
            input;
        }
        else{
            foreach($this->viewBag->data as $row){
                echo <<<input
                            <tr scope="row">
                            <td scope="col"><a href="articulo.php?id={$row->idArticulo}" class="text-decoration-none">{$row->modelo}</a></td>
                            <td scope="col">{$row->estado}</td>
                            <td scope="col"><a href='marca.php?id={$row->idMarca}' class='text-decoration-none'>{$row->marca}</td>
                            <td scope="col"><a href='tipoarticulo.php?id={$row->idTipoArticulo}' class='text-decoration-none'>{$row->tipoArticulo}</td>
                            <td scope="col">{$row->fechaInventario}</td>
                            <td scope="col">{$row->fechaCompra}</td>
                                <td scope="col">
                                    <a href="#edit-modal-{$row->idExistencia}" data-toggle="modal"
                                    class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                                </td>
                            </tr>
                        <div class="modal fade" id="edit-modal-{$row->idExistencia}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Editar - {$row->modelo}</h3>
                                        <button class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="existencia.php" method="post" class="form-group">
                                            <input required name="idExistencia" value="{$row->idExistencia}" hidden>
                                            <div class="form-group">
                                                <label for="idArticulo">Modelo:</label>
                                                <select required name="idArticulo" id="idArticulo" class="form-control">
                                                    <option value='{$row->idArticulo}'>{$row->modelo}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="fechaCompra">Fecha de compra:</label>
                                                <input required type="date" name="fechaCompra" id="fechaCompra" value="{$row->fechaCompra}" class="form-control" placeholder="Escriba la dirección Ip">
                                            </div>
                                            <div class="form-group">
                                                <label for="estado">Estado:</label>
                                                <select required name="idEstado" id="estado" class="form-control">
                                                <option value='{$row->idEstado}' hidden>{$row->estado}</option>
                                                {$estados} 
                                                </select>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" value="Edit" type="submit" name="accion">Guardar cambios</button>
                                        <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                input;
            }
        }

      ?>
     </tbody>
  </table>
  </div>
  <div class="row justify-content-end">
      <a href="#add-modal" class="m-3" data-toggle="modal" id="agregar">Agregar existencia</a>
  </div>
</div>
</main>


<!-- MODAL PARA AGREGAR -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar existencia</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="existencia.php" method="post" class="form-group">
                    <div class="form-group">
                        <label for="idArticulo">Articulo:</label>
                        <select required name="idArticulo" id="idArticulo" class="form-control">
                            <option value="">Selecciona un modelo</option>
                                <?=$opciones?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechaCompra">Fecha de compra:</label>
                        <input required type="date" name="fechaCompra" id="fechaCompra" value="<?=date('Y-m-d')?>" class="form-control" placeholder="Escriba la dirección Ip">
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado:</label>
                        <select required name="idEstado" id="estado" class="form-control">
                        <option value="">Selecciona un estado</option>
                        <?=$estados?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" value="Add" type="submit" name="accion">Agregar</button>
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
            
           
        </div>
    </div>
</div>
