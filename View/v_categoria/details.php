<?php

    // use filter\Filter;
    // require_once('../../filters/filter.php');
    // $filter = new Filter;
    // $filter->Filtrar();
    
    $categoria = trim($this->viewBag->data[0]->categoria,'s,es');
    $categoria = strtolower($categoria);
?>
    <div class="jumbotron ml-2 mr-2 overflow-auto">

<h1 class="display-4">
    <?=$this->viewBag->data[0]->categoria;?>
</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item"><a href="categoria.php">Categorias</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$this->viewBag->data[0]->categoria;?></li>
        </ol>
    </nav>
</div>
<main class="w-100">
<div class="container">
  <ul class="list-group">
  
      <?php
            if($this->viewBag->children == null){
                echo<<<input
                    <span class="display-4 text-muted text-center">No existen registros</span>
                input;
            }
            else
            foreach($this->viewBag->children as $row){
                echo <<<input
                    <li class="list-group-item ">
                       <div class="btn container-fluid d-flex flex-wrap justify-content-between">
                        <a href="tipoarticulo.php?id={$row->idTipoArticulo}">{$row->tipoArticulo}</a>
                        <div>
                            <a href="#edit-modal-{$row->idTipoArticulo}" data-toggle="modal" 
                            class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                            <a href="#remove-modal" data-titulo="{$row->tipoArticulo}" data-id="{$row->idTipoArticulo}" class="badge badge-pill btn-outline-danger" data-toggle="modal"><span class="">Eliminar</span></a>
                        </div>
                        </div>
                    </li>
                    <div class="modal fade" id="edit-modal-{$row->idTipoArticulo}" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Editar - {$row->tipoArticulo}</h3>
                                    <button class="close" data-dismiss="modal">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="tipoArticulo.php?fv=categoria&id={$this->viewBag->data[0]->idCategoria}" method="post"
                                    class="form-group">
                                    <div class="form-group">
                                        <label for="idCategoria">Seleccione una categoria:</label>
                                        <select required id="idCategoria" name="idCategoria" class="form-control">
                                            <option value="{$row->idCategoria}">{$this->viewBag->data[0]->categoria}</option>
                                        </select>
                                    </div>
                                    <input required name="idTipoArticulo" value="{$row->idTipoArticulo}" hidden/> 
                                    <div class="form-group">
                                        <label for="tipoArticulo">Tipo de articulo</label>
                                        <input required type="text" id="tipoArticulo" name="tipoArticulo" value="{$row->tipoArticulo}" class="form-control" placeholder="Escriba un tipo de articulo" />
                                    </div>
                                    </div> 
                                <div class="modal-footer">
                                    <button class="btn btn-success" value="Edit" type="submit" name="accion" >Guardar cambios</button>  
                                    <button class="btn btn-outline-secondary" data-dismiss="modal" >Cancelar</button>
                                    </form>
                                </div>
                                                              
                            </div>
                        </div>
                    </div>
                input;
            }
      ?>
     
  </ul>
  <div class="row justify-content-end">
      <a href="#add-ctg" class="m-3" data-toggle="collapse" aria-expanded="false" aria-controls="add-ctg">Agregar <?=$categoria?></a>
  </div>

  <div class="collapse" id="add-ctg">
      <div class="card card-body">
          <label for="tipoArticulo" class="">Nuevo <?=$categoria?></label>
          <form action="tipoarticulo.php?fv=categoria&id=<?=$this->viewBag->data[0]->idCategoria?>" class="input-group" method="post">
          <input required type="text" class="form-control" id="tipoArticulo" name="tipoArticulo" placeholder="Introduzca nuevo <?=$categoria?>">
          <input required type="text" value="<?=$this->viewBag->data[0]->idCategoria?>" name = "idCategoria" hidden>
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
                Para eliminar esta categoria se deben eliminar todas sus existencias.
                ¿Deseas continuar?
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <form action="tipoArticulo.php?fv=categoria&id=<?=$this->viewBag->data[0]->idCategoria;?>" method="post">
                    <input required type="text" id="id-remove" name="id" hidden >
                    <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>


