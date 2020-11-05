<div class="p-5 border rounded col-11 col-sm-10 col-lg-8 m-auto" id="reporte">
    <div class="row justify-content-between mb-5">
        <div class="col-12 col-sm-6 col-md-5 text-left ">
            <h2>Ron Barceló</h2>
            <label for="entrega" class="font-weight-bold">#</label>
            <span id="entrega" class="border-bottom pl-3 pr-3"><?=$this->viewBag->data[0]->idEntrega?></span>
        </div>
        <div class="col-12 col-sm-6 col-md-7 text-right align-self-center">
            <label for="fecha" class="font-weight-bold col-12 col-md-7">Fecha de Entrega:</label>
            <span id="fecha" class="border-bottom pl-3 pr-3 col-12 col-md-5"><?=$this->viewBag->data[0]->fechaEntrega?></span>
        </div>
    </div>
    <div class="form-group row">
        <label for="nombre" class="font-weight-bold col-6 col-sm-3 col-md-2">Localidad:</label>
        <span id="nombre" class="border-bottom pl-3 pr-3 col-6 col-sm-6 col-md-4"><?=$this->viewBag->data[0]->localidad?></span>
    </div>
    <div class="form-group row">
        <label for="nombre" class="font-weight-bold col-4 col-sm-2">Para:</label>
        <span id="nombre" class="border-bottom pl-3 pr-3 col-8 col-sm-10"><?=$this->viewBag->data[0]->departamento.' / '.$this->viewBag->data[0]->codigoEmpleado ?></span>
    </div>
    <div class="table-responsive mb-4 mt-4">   
    <table class="table table-hover table-bordered">
        <thead class="rounded bg-light">
            <tr scope="row">
                <th scope="col">Articulo</th>
                <th scope="col">Modelo</th>
                <th scope="col">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if(isset($this->viewBag->children)){
                    foreach($this->viewBag->children as $row){?>
                    <tr scope="row">
                        <td scope="col"><?=$row->tipoArticulo?></td>
                        <td scope="col"><?=$row->modelo?></td>
                        <td scope="col"><?=$row->cantidad?></td>
                    </tr>
                <?php }}?>
        </tbody>
        <tfoot class="bg-light">
            <tr scope="row">
                <td scope="col" colspan="2" class="text-right font-weight-bold">Total de articulos:</td>
                <td scope="col"><?=$this->viewBag->data[0]->totalArticulos?></td>
            </tr>
        </tfoot>
    </table>
    </div>

    <div class="row justify-content-between">
        <div class="col-6 col-md-4">
            <div class="form-group text-center">
                <input type="text" class="form-control-plaintext border-bottom font-weight-bold text-center" value="<?=$this->viewBag->data[0]->recibidoPor?>">
                <span class="text-muted">Recibido por</span>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="form-group text-center">
                <input type="text" class="form-control-plaintext border-bottom font-weight-bold text-center" value="<?=$this->viewBag->data[0]->entregadoPor?>">
                <span class="text-muted">Entregado por</span>
            </div>
        </div>
    </div>
</div>
<div class="col-11 col-sm-10 col-lg-8 d-flex justify-content-between m-auto pt-2 pb-4">
   <a href="entrega.php">&laquo; Volver a entregas</a> 
   <form action="pdf.php" target="_blank" class="text-right">
        <input type="text" hidden name="idReporte" value="<?=$this->viewBag->data[0]->idEntrega?>">
        <label for="mail" class="ml-2"><input type="checkbox" name="mail" id="mail" checked > Recibir al correo</label>       
        <button type="submit" class="btn btn-outline-info ml-2" name="accion" value="Entrega" >Imprimir entrega</button>
   </form>
</div>