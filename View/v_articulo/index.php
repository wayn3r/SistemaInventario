<?php
    $marcas='';
    $tipos='';
    foreach($this->viewBag->marcas as $marca){
        $marcas .= "<option value='{$marca->idMarca}' >$marca->marca</option>";
    }
    foreach($this->viewBag->tipos as $tipo){
        $tipos .= "<option value='{$tipo->idTipoArticulo}' >$tipo->tipoArticulo</option>";
    }
?>
<div class="jumbotron">

<h1 class="display-4">
    Todos los modelos
</h1>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="categoria.php">Categoria</a></li>
        <li class="breadcrumb-item"><a href="tipoarticulo.php">Tipo de articulos</a></li>
        <li class="breadcrumb-item active" aria-current="page">Articulos</li>
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
            <th scope="col">Marca</th>
            <th scope="col">Articulo</th>
            <th scope="col">Cantidad Contada</th>
            <th scope="col">Cantidad en Stock</th>
            <th scope="col">Fecha Inventario</th>
            <th scope="col">Fecha Compra</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    
      <?php
            if($this->viewBag->data == null){
                echo<<<input
                    <tr scope="row">
                        <td scope="col" colspan="8" class="text-center">
                            <span class="display-4 text-muted ">No existen registros</span>
                        </td>
                    </tr>
                input;
            }
            else
            foreach($this->viewBag->data as $row){
                $page = 'articulo';
                $isPrinter = trim(strtolower($row->tipoArticulo),'s') == 'impresora';
                if($isPrinter){
                    $page='impresora';
                }
                echo <<<input
                            <tr scope="row">
                                <td scope="col"><a href="{$page}.php?id={$row->idArticulo}" class="text-decoration-none">{$row->modelo}</a></td>
                                <td scope="col"><a href="{$row->idMarca}" class="text-decoration-none">{$row->marca}</a></td>
                                <td scope="col"><a href="tipoarticulo.php?id={$row->idTipoArticulo}" class="text-decoration-none">{$row->tipoArticulo}</a></td> 
                                <td scope="col">{$row->cantidadContada}</td>
                                <td scope="col">{$row->cantidadStock}</td>
                                <td scope="col">{$row->fechaInventario}</td>
                                <td scope="col">{$row->fechaCompra}</td>
                                <td scope="col">
                                    <a href="#edit-modal-{$row->idArticulo}" data-toggle="modal"
                                    class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                                    <a href="#remove-modal" data-titulo="{$row->modelo}" data-id="{$row->idArticulo}" class="badge badge-pill btn-outline-danger" data-toggle="modal"><span class="">Eliminar</span></a>
                                </td>
                            </tr>
                        <div class="modal fade" id="edit-modal-{$row->idArticulo}" tabindex="-2">
                            <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Editar - {$row->modelo}</h3>
                                            <button class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="articulo.php" class="form-group" method="post">
                                                <div class="form-group">
                                                    <label for="idTipoArticulo">Tipo de articulo:</label>
                                                    <select required name="idTipoArticulo" id="idTipoArticulo" class="form-control">
                                                        <option value="{$row->idTipoArticulo}" hidden>{$row->tipoArticulo}</option>
                                                            {$tipos}
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="idMarca">Marca:</label>
                                                    <select required name="idMarca" id="idMarca" class="form-control">
                                                        <option value="{$row->idMarca}">{$row->marca}</option>
                                                            {$marcas}
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="modelo">Modelo:</label>
                                                    <input required type="text" name="modelo" id="modelo" class="form-control" placeholder="Escribe un nuevo modelo" value="{$row->modelo}">
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-success" value="Edit" type="submit" name="accion">Guardar cambios</button>
                                            <input type="text" id="id-edit" name="idArticulo" value="{$row->idArticulo}" hidden />
                                            <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>    
                                            </form>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            
                input;
            }
      ?>
     </tbody>
  </table>
  </div>
  <div class="row justify-content-end">
      <a href="#add-modal" class="m-3" data-toggle="modal" aria-expanded="false" aria-controls="add-ctg">Agregar modelo</a>
  </div>


</div>
</main>
<!-- MODAL ELIMINAR-->
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
                Para eliminar este modelo se deben eliminar todas sus existencias.
                ¿Deseas continuar?
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <form action="articulo.php" method="post">
                    <input required type="text" id="id-remove" name="id" hidden>
                    <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODAL AGREGAR -->
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar modelo</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form action="articulo.php" class="form-group" method="post">
                    <div class="form-group">
                        <label for="idTipoArticulo">Tipo de articulo:</label>
                        <select required name="idTipoArticulo" id="idTipoArticulo" class="form-control">
                            <option value="">Seleccione un tipo de articulo</option>
                            <?=$tipos?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idMarca">Marca:</label>
                        <select required name="idMarca" id="idMarca" class="form-control">
                            <option value="">Seleccione una marca</option>
                            <?=$marcas?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input required type="text" name="modelo" id="modelo" class="form-control" placeholder="Escribe un nuevo modelo">
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