<div class="col-12">
    <div class="jumbotron ml-2 mr-2 overflow-auto">
        <h1 class="display-4">Historico</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Historico</li>
            </ol>
        </nav>
    </div>

    <div class="col-12 col-md-6 container m-auto">
        <div class="row">
            <a href="home.php" class="ml-3">&laquo; Volver al inicio</a>
            <a href="historico.php?accion=Inventario" class="btn btn-success ml-auto mr-3">Registrar inventario actual</a>
        </div>
        <div class="alert alert-light border-left" >Ver historico de articulos o impresoras</div>
        <span class="text-danger"><?=isset($this->viewBag->historico['error'])?$this->viewBag->historico['error']:''?></span>
        <form action="historico.php" class="m-auto needs-validation <?=isset($this->viewBag->historico['error'])?'was-validated':''?>" method="post" id='entrega_articulo' novalidate>
                <div class="form-group">
                    <label>Tipo de historico:</label>
                    <select name="tipo" id="tipo" class="custom-select">
                        <option value="">Seleccione un tipo</option>
                        <option value="articulo">Articulo</option>
                        <option value="impresora">Impresora</option>
                    </select>
                    <span class="invalid-feedback">Por favor, selecciona un tipo de historico</span>
                </div>
                
                <?php if(isset($this->viewBag->fechas)){?>
                    <div class="alert alert-info collapse" id='fechas'>
                        <div class="d-flex justify-content-between">
                            <span>Posibles fechas de historicos:</span>
                            <a href="#fechas" data-toggle="collapse">Ocultar</a>
                        </div>
                        <ol>
                    <?php if(count($this->viewBag->fechas) > 0){
                        foreach($this->viewBag->fechas as $fecha){?>
                        <li><a href="historico.php?id=<?=$fecha->idFecha?>&accion=Historico&tipo=articulo"><?=$fecha->fecha?></a></li>
                    <?php }}else{?>
                        <li><span class="text-muted">No existen historicos registrados</span></li>
                    <?php }?>
                        </ol>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="#fechas" data-toggle="collapse">Mostrar fechas</a>
                    </div>
                 <?php }?>
                    
                
                <div class="form-group" id='fecha'>
                    <label>Fecha historico:</label>
                    <input type="date" class="form-control" required  name="fecha" placeholder="dd/mm/yyyy">
                    <span class="invalid-feedback">Por favor, selecciona una fecha</span>
                </div>
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" value="Historico" name="accion" class="btn btn-outline-info">Ver historico &raquo;</button>
            </div>
        </form>
    </div>
</div>