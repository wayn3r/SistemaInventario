<div class="col-11 col-sm-10 col-lg-8 m-auto" >
    <div class="jumbotron">
        <span class="display-4 text-uppercase"><?=$this->viewBag->mes?>, <?=$this->viewBag->year?></span>
    </div>
    <?php if(isset($this->viewBag->canvas) && $this->viewBag->canvas['data'] != '[]'){?>
        <canvas id="grafico"></canvas>
        <div class="alert alert-light border-left" onclick="generarGrafico()"><?=$this->viewBag->mensaje?></div>
        <input id='cantidad'hidden value='<?=$this->viewBag->canvas['cantidad']?>'>
        <input id='data' hidden value='<?=$this->viewBag->canvas['data']?>'>
    <?php }?>
</div>

<div class="p-5 border rounded col-11 col-sm-10 col-lg-8 m-auto" id="reporte">
    <div class="row justify-content-between mb-5">
        <div class="col-12 col-sm-6 col-md-5 text-left ">
            <h2>Ron Barceló</h2>
            <label for="entrega" class="font-weight-bold">Reporte:</label>
            <span id="entrega" class="border-bottom pl-3 pr-3"><?=ucfirst($this->viewBag->mes).', '.$this->viewBag->year?></span>
        </div>
        <div class="col-12 col-sm-6 col-md-7 text-right align-self-center">
            <label for="fecha" class="font-weight-bold col-12 col-md-7">Fecha:</label>
            <span id="fecha" class="border-bottom pl-3 pr-3 col-12 col-md-5"><?=date('Y-m-d')?></span>
        </div>
    </div>
    <div class="form-group row">
        <label for="nombre" class="font-weight-bold col-2">Reporte por:</label>
        <span id="nombre" class="border-bottom pl-3 pr-3 col-10 align-self-end"><?=$this->viewBag->cuser['nombre']. ' ' .$this->viewBag->cuser['apellido']?></span>
    </div>
    <div class="container">        
        <div class="row">
           <div class="table-responsive  m-auto">
               <table class="table table-hover table-stripped">
                   <thead>
                       <tr scope="row">
                           <?php switch($this->viewBag->titulo){
                               case 'articulos':?>
                                <th scope="col">Fecha Inventario</th>
                                <th scope="col">Fecha Compra</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Articulo</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Contado</th>
                                <th scope="col">Stock</th>
                               <?php break;
                               case 'entregas':?>
                                <th scope="col">#</th>
                                <th scope="col">Fecha Entrega</th>
                                <th scope="col">Recibido por</th>
                                <th scope="col">Codigo de empleado</th>
                                <th scope="col">Entregado por</th>
                                <th scope="col">Departamento</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Total articulos entregados</th>
                           <?php break; 
                            case 'impresoras':?>
                            <th scope="col">Fecha Inventario</th>
                            <th scope="col">Fecha compra</th>
                            <th scope="col">Número de serie</th>
                            <th scope="col">Dirección IP</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Estado</th>
                           <?php break;}?>
                       </tr>
                   </thead>
                   <tbody>
                   <?php switch($this->viewBag->titulo){
                               case 'articulos':
                                if(count($this->viewBag->data)>0){
                               foreach($this->viewBag->data as $row){?>
                               <tr scope="row">
                                   <td scope="col"><?=$row->fechaInventario?></td>
                                   <td scope="col"><?=$row->fechaCompra?></td>
                                   <td scope="col"><?=$row->categoria?></td>
                                   <td scope="col"><?=$row->tipoArticulo?></td>
                                   <td scope="col"><?=$row->modelo?></td>
                                   <td scope="col"><?=$row->cantidadContada?></td>
                                   <td scope="col"><?=$row->cantidadStock?></td>
                               </tr>
                               <?php }}else{?>
                            <tr scope="row">
                                <td colspan="7" class="text-center text-uppercase text-muted h5">
                                    No existen articulos para el filtro seleccionado
                                </td>
                            </tr>
                          <?php }break; 
                               case 'entregas':
                                if(count($this->viewBag->data)>0){
                                foreach($this->viewBag->data as $row){?>
                                <tr scope="row">
                                   <td scope="col"><?=$row->idEntrega?></td>
                                   <td scope="col"><?=$row->fechaEntrega?></td>
                                   <td scope="col"><?=$row->recibidoPor?></td>
                                   <td scope="col"><?=$row->codigoEmpleado?></td>
                                   <td scope="col"><?=$row->entregadoPor?></td>
                                   <td scope="col"><?=$row->departamento?></td>
                                   <td scope="col"><?=($row->terminado == '1')?'Completada':'Pendiente'?></td>
                                   <td scope="col"><?=$row->totalArticulos?></td>
                               </tr>
                           <?php }}else{?>
                            <tr scope="row">
                                <td colspan="8" class="text-center text-uppercase text-muted h5">
                                    No existen entregas para el filtro seleccionado
                                </td>
                            </tr>
                          <?php }break;  
                            case 'impresoras':
                                if(count($this->viewBag->data)>0){
                               foreach($this->viewBag->data as $row){?>
                               <tr scope="row">
                                   <td scope="col"><?=$row->fechaInventario?></td>
                                   <td scope="col"><?=$row->fechaCompra?></td>
                                   <td scope="col"><?=$row->serialNumber?></td>
                                   <td scope="col"><?=$row->direccionIp?></td>
                                   <td scope="col"><?=$row->modelo?></td>
                                   <td scope="col"><?=$row->marca?></td>
                                   <td scope="col"><?=$row->estado?></td>
                               </tr>
                               <?php }}else{?>
                            <tr scope="row">
                                <td colspan="7" class="text-center text-uppercase text-muted h5">
                                    No existen articulos para el filtro seleccionado
                                </td>
                            </tr>
                          <?php }break; }?>
                   </tbody>
                   <tfoot>
                       <tr scope="row" class="">
                           <td scope="col" colspan="7" class="text-muted border-top-0"><?=$this->viewBag->mensaje?></td>
                       </tr>
                   </tfoot>
               </table>
           </div>
        </div>
    </div>
    </div>
<div class="col-11 col-sm-10 col-lg-8 d-flex justify-content-between m-auto pt-2 pb-4">
   <a href="reporte.php">&laquo; Volver a reportes</a> 
   <form action="pdf.php" target="_blank" class="text-right">
       <input type="text" hidden name="filtro" value="<?=isset($this->viewBag->reporte['filtro'])?$this->viewBag->reporte['filtro']:''?>" required>
       <input type="text" hidden name="tipo" value="<?=isset($this->viewBag->reporte['tipo'])?$this->viewBag->reporte['tipo']:''?>" required>
       <?php switch($this->viewBag->reporte['tipo']){
           case 'mes':?>
            <input type="text" hidden name="mes" value="<?=isset($this->viewBag->reporte['mes'])?$this->viewBag->reporte['mes']:''?>">
        <?php break;
            case 'dia':?>
        <input type="text" hidden name="dia" value="<?=isset($this->viewBag->reporte['dia'])?$this->viewBag->reporte['dia']:''?>">
        <?php break;
            case 'estado':?>
        <input type="text" hidden name="idEstado" value="<?=isset($this->viewBag->reporte['idEstado'])?$this->viewBag->reporte['idEstado']:''?>">
        <?php break;
            case 'marca':?>
        <input type="text" hidden name="idMarca" value="<?=isset($this->viewBag->reporte['idMarca'])?$this->viewBag->reporte['idMarca']:''?>">
        <?php break;
            case 'rango':?>
        <input type="text" hidden name="desde" value="<?=isset($this->viewBag->reporte['desde'])?$this->viewBag->reporte['desde']:''?>">
        <input type="text" hidden name="hasta" value="<?=isset($this->viewBag->reporte['hasta'])?$this->viewBag->reporte['hasta']:''?>">
        <?php break;
            case 'fechaentrada':?>
        <input type="text" hidden name="desdefe" value="<?=isset($this->viewBag->reporte['desdefe'])?$this->viewBag->reporte['desdefe']:''?>">
        <input type="text" hidden name="hastafe" value="<?=isset($this->viewBag->reporte['hastafe'])?$this->viewBag->reporte['hastafe']:''?>">
        <?php break;
            case 'fechacompra':?>
        <input type="text" hidden name="desdefc" value="<?=isset($this->viewBag->reporte['desdefc'])?$this->viewBag->reporte['desdefc']:''?>">
        <input type="text" hidden name="hastafc" value="<?=isset($this->viewBag->reporte['hastafc'])?$this->viewBag->reporte['hastafc']:''?>">
        <?php break;}?>
        <label for="mail" class="ml-2"><input type="checkbox" name="mail" id="mail" checked > Recibir al correo</label>       
        <button type="submit" class="btn btn-outline-info ml-2" name="accion" value="Reporte" >Imprimir reporte</button>
   </form>
</div>
