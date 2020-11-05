
    <div class="jumbotron ml-2 mr-2 overflow-auto">

<h1 class="display-4">
    Tipo de articulos
</h1>
<nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item"><a href="categoria.php">Categoria</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tipo de articulos</li>
        </ol>
</nav>
</div>
<main class="w-100">
<div class="container">
<div class="table-responsive">    
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th scope="col">Tipo de Articulo</th>
            <th scope="col">Categoria</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
<?php
if(isset($this->viewBag->opciones)){
    $opciones = '';
    foreach($this->viewBag->opciones as $categoria){
        $opciones .= "<option value='{$categoria->idCategoria}'>$categoria->categoria</option>" ;
    }
}

if($this->viewBag->data == null){
    echo<<<input
        <tr scope="row">
            <td scope="col" colspan="4" class="text-center">
                <span class="display-4 text-muted ">No existen registros</span>
            </td>
        </tr>
    input;
}
else
foreach($this->viewBag->data as $row){
    echo <<<input
            <tr scope="row" data-link="tipoArticulo.php?id={$row->idTipoArticulo}">
                
                <td scope="col"><a href="tipoarticulo.php?id={$row->idTipoArticulo}" class="text-decoration-none">{$row->tipoArticulo} </a></td>
                <td scope="col"><a href="categoria.php?id={$row->idCategoria}" class="text-decoration-none">{$row->categoria} </a></td>
                <td scope="col">
                    <a href="#edit-modal-{$row->idTipoArticulo}" data-toggle="modal"
                    class="badge badge-pill btn-outline-info"><span class="">Editar</span></a>
                    <a href="#remove-modal" class="badge badge-pill btn-outline-danger" data-titulo="{$row->tipoArticulo}" data-id="{$row->idTipoArticulo}" data-toggle="modal"><span class="">Eliminar</span></a>
                </td>
            
            </tr>
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
                            <form action="tipoarticulo.php" method="post"
                            class="form-group">
                            <div class="form-group">
                                <label for="edit-idCategoria">Categoria:</label>                                            
                                <select id="edit-idCategoria" name="idCategoria" class="form-control">
                                    <option value="{$row->idCategoria}" hidden>{$row->categoria}</option>
                                    {$opciones}
                                </select>
                            </div>
                            <input name="idTipoArticulo" value="{$row->idTipoArticulo}" hidden/> 
                            <div class="form-group">
                                <label for="edit-tipoArticulo">Tipo de articulo:</label>
                                <input type="text" id="edit-tipoArticulo" name="tipoArticulo" value="{$row->tipoArticulo}" class="form-control" placeholder="Escriba un tipo de articulo" />
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" data-dismiss="modal" >Cancelar</button>
                                <button class="btn btn-success" value="Edit" type="submit" name="accion" >Guardar cambios</button>  
                            </div>
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
      <a href="#add-modal" class="m-3" data-toggle="modal" >Agregar articulo</a>
  </div>

</div>
</main>


<div class="modal fade" id="add-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar tipo de articulo</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="tipoarticulo.php" class="form-group" method="post">
                    <div class="form-group">
                        <label for="idCategoria">Categoria:</label>
                        <select id="idCategoria" name="idCategoria" class="form-control">
                            <?=$opciones?>
                            <option value="" selected>Seleccione una categoria</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipoArticulo">Tipo de articulo:</label>
                        <input type="text" class="form-control" id="tipoArticulo" name="tipoArticulo" placeholder="Introduzca nuevo tipo de articulo">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" value="Add" name="accion" class="btn btn-success ">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
                Para eliminar este tipo de articulo se deben eliminar todos sus modelos.
                ¿Deseas continuar?
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <form action="tipoarticulo.php" method="post">
                    <input type="text" id="id-remove" name="id" hidden>
                    <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>