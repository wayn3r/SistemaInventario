<?php
    $tipoArticulo = $this->viewBag->data[0]->tipoArticulo;
    $tipoArticulo = strtolower($tipoArticulo);
    $marcas = '';
    foreach($this->viewBag->opciones as $marca){
        $marcas .= "<option value='{$marca->idMarca}' >$marca->marca</option>";
    }

?>
<div class="jumbotron">
    <h1 class="display-4">
        <?=$this->viewBag->data[0]->tipoArticulo;?>
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="categoria.php">Categoria</a></li>
            <li class="breadcrumb-item"><a href="categoria.php?id=<?=$this->viewBag->data[0]->idCategoria;?>"><?=$this->viewBag->data[0]->categoria;?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$this->viewBag->data[0]->tipoArticulo;?></li>
        </ol>
    </nav>
</div>
<main class="w-100">
<div class="container">
<div class="table-responsive-xl">
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th class="" scope="col">Articulo</th>
            <th class="" scope="col">Modelo</th>
            <th class="" scope="col">Marca</th>
            <th class="" scope="col">Cantidad Contada</th>
            <th class="" scope="col">Cantidad en Stock</th>
            <?php 
                if(isset($this->viewBag->toners)){
                    echo" <th class='' scope='col'>Toner</th>"; 
                    $toners='';
                    foreach($this->viewBag->toners as $toner){
                        $toners .= "<option value = '{$toner->idArticulo}'>{$toner->modelo}</option>";
                    }
                }


            ?>
            <th class="" scope="col">Fecha Inventario</th>
            <th class="" scope="col">Fecha Compra</th>
            <th class="" scope="col"></th>
        </tr>
    </thead>
    <tbody>
    
      <?php


            if($this->viewBag->children == null){
                echo<<<input
                    <tr scope="row">
                        <td scope="col" colspan="7"  class="text-center">
                            <span class="display-4 text-muted ">No existen registros</span>
                        </td>
                    </tr>
                input;
            }
            else
            foreach($this->viewBag->children as $row){

                $page = 'articulo';
                $fila = '';
                $eliminar = '';
                if(isset($row->toners)){
                    $page='impresora';
                    $toner_impresora = '';
                    foreach($row->toners as $toner){
                        $toner_impresora .="<div class='dropdown-item d-flex justify-content-between'>
                            {$toner->modelo} <a href='toner_impresora.php?fv=tipoarticulo&id={$this->viewBag->data[0]->idTipoArticulo}&accion=Remove&idT={$toner->idToner}&idI={$toner->idImpresora}' 
                            class='rounded btn-outline-danger text-decoration-none' style='cursor: pointer;'>&times;</a>
                        </div>";
                    }
                    if($toner_impresora == '')
                        $toner_impresora = "<div class='dropdown-item' >Sin registros</div>";

                    $fila = <<<input
                    <td scope="col">
                    <div class="dropdown show">
                        <a class="dropdown-toggle" role="button"                 
                        id="dropdownMenuLink" data-toggle="dropdown" 
                        aria-haspopup="true" aria-expanded="false">
                            Ver
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            {$toner_impresora}
                            <div class="dropdown-divider"></div>
                                <a href="#add-toner-modal" class="dropdown-item" data-titulo='{$row->modelo}' data-id='{$row->idArticulo}' data-toggle="modal">Agregar toner</a>
                            </div>
                        </div>
                    </td>
                    input;
                }
                else{
                    $eliminar =<<<input
                        <a href="#remove-modal" data-titulo="{$row->modelo}" data-id="{$row->idArticulo}" class="badge badge-pill btn-outline-danger" data-toggle="modal"><span class="">Eliminar</span></a>
                    input;
                }
                echo <<<input
                        <tr scope="row" >
                            <td scope="col">{$row->tipoArticulo}</td>
                            <td scope="col"><a href="{$page}.php?id={$row->idArticulo}" class="text-decoration-none">{$row->modelo}</a></td>
                            <td scope="col"><a href="marca.php?id={$row->idMarca}" class="text-decoration-none">{$row->marca}</a></td>
                            <td scope="col">{$row->cantidadContada}</td>
                            <td scope="col">{$row->cantidadStock}</td>
                            {$fila}
                            <td scope="col">{$row->fechaInventario}</td>
                            <td scope="col">{$row->fechaCompra}</td>
                            <td class="" scope="col">
                                <a href="#edit-modal-{$row->idArticulo}" data-toggle="modal"
                                class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                                {$eliminar}
                            </td>
                        </tr>
                        <div class="modal fade" id="edit-modal-{$row->idArticulo}" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Editar modelo</h3>
                                        <button class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                       <form action="articulo.php?fv=tipoarticulo&id={$this->viewBag->data[0]->idTipoArticulo}" class="form-group" method="post">
                                            <div class="form-group">
                                                <label for="idTipoArticulo">Tipo de articulo:</label>
                                                <select required name="idTipoArticulo" id="idTipoArticulo" class="form-control">
                                                    <option value="{$this->viewBag->data[0]->idTipoArticulo}">{$this->viewBag->data[0]->tipoArticulo}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="idMarca">Marca:</label>
                                                <select required name="idMarca" id="idMarca" class="form-control">
                                                    <option value="{$row->idMarca}" hidden>{$row->marca}</option>
                                                    {$marcas}
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="modelo">Modelo:</label>
                                                <input required type="text" value="{$row->modelo}" name="modelo" id="modelo" class="form-control" placeholder="Escribe un modelo">
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button class="btn btn-success" value="Edit" type="submit" name="accion">Guardar cambios</button>
                                    <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                                        <input required type="text" id="id-edit" name="idArticulo" value="{$row->idArticulo}" hidden>
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
  <div class="d-flex justify-content-end">
      <a href="#add-modal" class="m-3" data-toggle="modal" aria-expanded="false" aria-controls="add-ctg">Agregar <?=$tipoArticulo?></a>
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
                <form action="articulo.php?fv=tipoarticulo&id=<?=$this->viewBag->data[0]->idTipoArticulo?>" method="post">
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
                <h3 class="modal-title">Editar modelo</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form action="articulo.php?fv=tipoarticulo&id=<?=$this->viewBag->data[0]->idTipoArticulo;?>" class="form-group" method="post">
                    <div class="form-group">
                        <label for="idTipoArticulo">Tipo de articulo:</label>
                        <select required name="idTipoArticulo" id="idTipoArticulo" class="form-control">
                            <option value="<?=$this->viewBag->data[0]->idTipoArticulo;?>"><?=$this->viewBag->data[0]->tipoArticulo;?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="idMarca">Marca:</label>
                        <select required name="idMarca" id="idMarca" class="form-control">
                            <option value="">Selecciona una marca</option>
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
<!-- MODAL PARA AGREGAR TONERS -->
<div class="modal fade" id="add-toner-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar toner -</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="toner_impresora.php?fv=tipoarticulo&id=<?=$this->viewBag->data[0]->idTipoArticulo?>" method="post">
                    <input required type="text" id="idImpresora" name="idImpresora" hidden>
                    <select required class="form-control"  name="idToner">
                        <option value="">Selecciona un toner</option>
                       <?=$toners?>
                    </select>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success" value="Add" type="submit" name="accion">Aceptar</button>
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>