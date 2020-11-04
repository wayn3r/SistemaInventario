<div class="col-12 mb-1 mt-3">
    <div class="progress col-11 col-sm-9 col-md-8 p-0 m-auto">
        <div class="progress-bar bg-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">Completado 100%</div>
    </div>
</div>
<div class="alert alert-success col-11 col-sm-9 col-md-8 m-auto border rounded border-dark text-center p-3">
    <span class="font-weight-bold">La entrega se ha completado de manera exitosa.</span>
    <section class="border-top border-dark text-left m-3 pt-3 ">
        <div class="row">
            <span class="font-weight-bold col-6">Número de entrega:</span>
            <span class="col-6 align-self-end "><?=$this->viewBag->data->idEntrega?></span>
        </div>
        <div class="row">
            <span class="font-weight-bold col-6">Entrega para:</span>
            <span class="col-6 align-self-end"><?=$this->viewBag->data->recibidoPor?></span>
        </div>
        <div class="row">
            <span class="font-weight-bold col-6">Entregado por:</span>
            <span class="col-6 align-self-end"><?=$this->viewBag->data->entregadoPor?></span>
        </div>
        <div class="row">
            <span class="font-weight-bold col-6">Total de articulos:</span>
            <span class="col-6 align-self-end"><?=$this->viewBag->data->totalArticulos?></span>
        </div>
        <div class="row">
            <span class="font-weight-bold col-6">Fecha de entrega:</span>
            <span class="col-6 align-self-end"><?=$this->viewBag->data->fechaEntrega?></span>
        </div>
        <div class="row">    
            <span class="font-weight-bold col-6">Estado:</span>
            <span class="col-6 align-self-end"><?=($this->viewBag->data->terminado==1?'Completada':'Imcompleta')?></span>
        </div>
        
    </section>
</div>
<div class="col-11 col-sm-9 col-md-8 m-auto">
    <div class="row justify-content-between p-0 no-gutters m-3">
        <a href="entrega.php" class="text-muted">&laquo; Volver a entregas</a>
        <a href="entrega.php?id=<?=$this->viewBag->data->idEntrega?>" class="row btn btn-success">Ver detalles &raquo;</a>
    </div>
</div>
