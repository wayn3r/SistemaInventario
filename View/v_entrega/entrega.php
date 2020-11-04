<div class="col-11 col-sm-9 col-md-8 col-lg-6 m-auto container">
    <div class="progress mt-5">
        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
    </div>
    <form action="entrega.php" novalidate class="needs-validation border rounded m-2 p-4 <?=isset($this->viewBag->error)?'was-validated':''?>" method="post">
        <div class="alert alert-light border-left pb-0">
            <span class="h5">Datos del empleado receptor</span>
        </div>
    <div class="form-group <?=isset($this->viewBag->error['empleado'])?'is-invalid':''?>">
        <div class="d-flex justify-content-between ">
            <label for="">Codigo de Empleado:</label>
            <a href="empleado.php" class="ml-auto">Agregar nuevo empleado</a>
        </div>
        <input type="text" class="form-control" list="empleados" name="codigoEmpleado" placeholder="Escriba el codigo de empleado del receptor" value="<?=isset($this->viewBag->data->codigoEmpleado)?$this->viewBag->data->codigoEmpleado:''?>" required>
        <?php if(isset($this->viewBag->empleados)){?>
            <datalist id="empleados">
                <?php foreach($this->viewBag->empleados as $row){?>
                <option value="<?=$row->codigoEmpleado?>"></option>
                <?php }?>
            </datalist>
        <?php }?>
    </div>
    <div class="form-group">
        <label for="">Fecha de entrega:</label>
        <input type="date" class="form-control" readonly value="<?=date('Y-m-d')?>" value="<?=isset($this->viewBag->data->fechaEntrega)?$this->viewBag->data->fechaEntrega:''?>" required>
    </div>
    <div class="form-group row justify-content-between col-12 p-0 no-gutters">
        <a <?=isset($this->viewBag->data->idEntrega)?'href="#remove" data-toggle="modal"':'href="entrega.php"'?> class="btn btn-danger col-5 col-sm-4 col-md-3 col-lg-2">Cancelar</a>
        <input name="idEntrega" value="<?=isset($this->viewBag->data->idEntrega)?$this->viewBag->data->idEntrega:''?>" <?=isset($this->viewBag->data->idEntrega)?'required':''?> hidden>
        <button type="submit" class="btn btn-success col-6 col-sm-5 col-md-4 col-lg-3" name="accion" value="<?=isset($this->viewBag->data->idEntrega)?'Edit':'Add'?>">Continuar &raquo;</button>
    </div>
</form>
</div>
<?php if(isset($this->viewBag->data->idEntrega)){?>
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
                    <input type="text" value="<?=$this->viewBag->data->idEntrega?>" required name="id" hidden>
                    <button class="btn btn-danger" value="Remove" type="submit" name="accion">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }?>