
<div class="jumbotron ml-2 mr-2 overflow-auto">

        <h1 class="display-4">
        Impresoras
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item"><a href="categoria.php">Categoria</a></li>
                <li class="breadcrumb-item"><a href="tipoarticulo.php">Tipo de articulos</a></li>
                <li class="breadcrumb-item"><a href="articulo.php">Articulos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Impresoras</li>
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
            <th scope="col">Número de serie</th>
            <th scope="col">Dirección IP</th>
            <th scope="col">Fecha Inventario</th>
            <th scope="col">Fecha Compra</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    
    <?php

            $estados = '';
            foreach($this->viewBag->estados as $estado){
                $estados .= "<option value = '{$estado->idEstado}'>{$estado->estado}</option>";
            }

            $articulos ='';
            if($this->viewBag->articulos != null){
                foreach($this->viewBag->articulos as $articulo){
                    $articulos .="<option value='{$articulo->idArticulo}'>{$articulo->modelo}</option>";
                }
            }
         if($this->viewBag->data == null){
            echo<<<input
                <tr scope="row">
                    <td scope="col" colspan="9" class="text-center">
                        <span class="display-4 text-muted ">No existen registros</span>
                    </td>
                </tr>
            input;
        }
        else{
            
            foreach($this->viewBag->data as $row){
                echo <<<input
                            <tr scope="row">
                            <td scope="col"><a href="impresora.php?id={$row->idArticulo}" class="text-decoration-none">{$row->modelo}</a></td>
                            <td scope="col">{$row->estado}</td>
                            <td scope="col"><a href='marca.php?id={$row->idMarca}' class='text-decoration-none'>{$row->marca}</td>
                            <td scope="col"><a href='tipoarticulo.php?id={$row->idTipoArticulo}' class='text-decoration-none'>{$row->tipoArticulo}</td>
                            <td scope="col">{$row->serialNumber}</td>
                            <td scope="col">{$row->direccionIp}</td>
                            <td scope="col">{$row->fechaInventario}</td>
                            <td scope="col">{$row->fechaCompra}</td>
                            <td scope="col">
                                    <a href="#edit-modal-{$row->idImpresora}" data-toggle="modal"
                                    class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                                    <a href="#remove-modal" data-titulo="{$row->serialNumber}" data-id="{$row->idImpresora}" class="badge badge-pill btn-outline-danger" data-toggle="modal"><span class="">Eliminar</span></a>
                                </td>
                            </tr>
                        <div class="modal fade" id="edit-modal-{$row->idImpresora}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Editar - {$row->modelo}</h3>
                                        <button class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="impresora.php" method="post" class="form-group">
                                            <input required name="idImpresora" value="{$row->idImpresora}" hidden>
                                            <div class="form-group">
                                                <label for="idArticulo">Modelo:</label>
                                                <select required name="idArticulo" id="idArticulo" class="form-control">
                                                    {$articulos}
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="serialNumber">Número de serie:</label>
                                                <input required type="text" value="{$row->serialNumber}" placeholder="Escribe el número de serie" name="serialNumber" id="serialNumber" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="direccionIp">Dirección IP:</label>
                                                <input type="text" value="{$row->direccionIp}" placeholder="Escribe dirección IP" name="direccionIp" id="direccionIp" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="fechaCompra">Fecha de compra:</label>
                                                <input required type="date" value="{$row->fechaCompra}" name="fechaCompra" id="fechaCompra" class="form-control" placeholder="yyyy-mm-dd">
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
      <a href="#add-modal" class="m-3" data-toggle="modal" id="agregar">Agregar impresora</a>
  </div>
</div>
</main>

<!-- MODAL PARA ELIMINAR -->
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
                ¿Deseas eliminar esta impresora?
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <form action="impresora.php" method="post">
                    <input required type="text" id="id-remove" name="id" hidden>
                    <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODAL PARA AGREGAR -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar impresora</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="impresora.php" method="post" class="form-group">
                    <div class="form-group">
                        <label for="idArticulo">Articulo:</label>
                        <select required name="idArticulo" id="idArticulo" class="form-control">
                            <option value="">Selecciona un modelo</option>
                                <?=$articulos?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="serialNumber">Número de serie:</label>
                        <input required type="text" placeholder="Escribe el número de serie" name="serialNumber" id="serialNumber" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="direccionIp">Dirección IP:</label>
                        <input type="text" placeholder="Escribe dirección IP" name="direccionIp" id="direccionIp" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="fechaCompra">Fecha de compra:</label>
                        <input required type="date" name="fechaCompra" id="fechaCompra" class="form-control" placeholder="yyyy-mm-dd">
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
