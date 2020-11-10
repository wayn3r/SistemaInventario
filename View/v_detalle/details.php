<div class="container p-5">
    <a href="entrega.php?id=<?=$this->viewBag->receptor->idEntrega?>&accion=Entrega">&laquo; Volver</a>
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
    </div>
<table class="table table-hover mt-3">
    <caption><p>Entrega para: <strong><?=$this->viewBag->receptor->recibidoPor?></strong></p></caption>
    <thead>
        <th>Cantidad</th>
        <th>Articulo</th>
        <th>Modelo</th>
        <th></th>
    </thead>
    <tbody>
        <?php
        if(count($this->viewBag->data) > 0){
            foreach($this->viewBag->data as $row){?>
            <tr>
                <td><?=$row->cantidad?></td>
                <td><?=$row->tipoArticulo?></td>
                <td><?=$row->modelo?></td>
                <td><a href="detalle.php?id=<?=$row->idEntrega?>&accion=Remove&idArticulo=<?=$row->idArticulo?>&cantidad=<?=$row->cantidad?>" class="badge badge-pill btn-outline-danger">Eliminar</a></td>
            </tr>
        <?php }}else{?>
            <tr class="text-center"><td colspan="4" class="text-muted">No se han agregado productos al detalle</td></tr>
        <?php }?>
    </tbody>
    <tfoot>
        <tr><td colspan="4"><a href="#products" data-toggle="modal">Agregar producto</a></td></tr>
    </tfoot>
</table>
<div class="row justify-content-between">
    <a href="#remove" data-toggle="modal" class="btn btn-danger col-4 col-md-3 col-lg-2">Cancelar entrega</a>
    <a href="detalle.php?accion=Completar&id=<?=$this->viewBag->receptor->idEntrega?>" class="btn btn-success col-5 col-md-4 col-lg-3 <?=count($this->viewBag->data)>0?'':'disabled'?>">Completar entrega &raquo;</a>
</div>
<?php if(count($this->viewBag->data)==0){?>
<div class="row justify-content-end ">
    <span class="text-muted col-6 text-right">Agrega articulos al detalle</span>
</div>
<?php }?>
</div>

<!-- MODAL PARA AGREGAR DETALLE -->
<div class="modal fade" id="products" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Agregar producto al detalle</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="detalle.php?id=<?=$this->viewBag->receptor->idEntrega?>" name='agregarForm' method="post" class="form-group needs-validation" novalidate>
                    <div class="form-group">
                        <label for="idTipoArticulo">Articulo:</label>
                        <select required name="idTipoArticulo" id="idTipoArticulo" class="custom-select" onchange="addOptions()">
                            <option value="">Seleccione un articulo</option>
                            <?php if(isset($this->viewBag->tipoarticulos)){
                                foreach($this->viewBag->tipoarticulos as $option){?>
                                <option value="<?=$option->idTipoArticulo?>"><?=$option->tipoArticulo?></option>
                            <?php }}?>
                        </select>
                        <div class="invalid-feedback"><p>Por favor, selecciona un articulo de la lista</p></div>
                    </div>
                    <div class="form-group">
                        <label for="idArticulo">Modelo:</label>
                        <textarea hidden id="modelos-json"><?=$this->viewBag->articulos?></textarea>
                        <select required name="idArticulo" id="idArticulo" class="custom-select" onchange="maxValue()" >
                        <option value="">Seleccione un modelo</option>
                        </select>
                        <div class="invalid-feedback"><p>Por favor, selecciona un modelo de la lista</p></div>
                    </div>
                   
                    <div class="row">
                    <div class="form-group col-6">
                        <label for="cantidad">Número de existencias:</label>
                        <input required type="number" name="cantidad" id="cantidad" value="1" max='1' min='1' class="form-control" placeholder="Escriba la cantidad de existencias a agregar">
                        <div class="invalid-feedback"><p id="cantidadFeedBack">Por favor, selecciona un modelo de la lista</p></div>
                    </div>
                    </div>
                    <input hidden value="<?=$this->viewBag->receptor->idEntrega?>" name="idEntrega">
            </div>
            <div class="modal-footer">
                    <button class="btn btn-success" value="Add" type="submit" name="accion">Agregar</button>
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                </form>
            </div>           
        </div>
    </div>
</div>
<!-- MODAL PARA ELIMINAR ENTREGA -->
<div class="modal fade" id="remove" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Cancelar entrega</h3>
                <button class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Estas a punto de cancelar esta entrega, esta acción es irreversible. 
                ¿Deseas continuar?
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <form action="entrega.php" method="post">
                    <input type="text" value="<?=$this->viewBag->receptor->idEntrega?>" required name="id" hidden>
                    <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>