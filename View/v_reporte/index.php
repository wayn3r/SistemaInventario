<div class="col-12">
    <div class="jumbotron ml-2 mr-2 overflow-auto">
        <h1 class="display-4">Reporte</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reporte</li>
            </ol>
        </nav>
    </div>

    <div class="col-12 col-md-6 container m-auto">
        <div class="row">
            <a href="home.php" class="ml-3">&laquo; Volver al inicio</a>
        </div>
        <div class="accordion" id='all'>
        <div class="alert alert-light border-left" data-target='#entrega_articulo' data-toggle="collapse" role="button">Generar reportes de entregas o articulos</div>
        <form action="reporte.php" class="m-auto needs-validation collapse <?=isset($this->viewBag->data['tipo'])?'show':''?> <?=isset($this->viewBag->data['error'])?'was-validated':''?>" method="post" id='entrega_articulo' novalidate data-parent='#all'>
            <div class="accordion" id="accordion">
                <div class="btn-toolbar mb-3 btn-group-toggle " role="toolbar" data-toggle="buttons">
                    <div class="btn-group btn-group-lg mr-2" role="group" >
                    <label class="btn btn-secondary">
                        <input type="radio" required name="tipo" <?=isset($this->viewBag->data['tipo'])?($this->viewBag->data['tipo']=='mes'?'checked':''):'checked'?> onchange="selectedFilter()" value="mes" id="" autocomplete="off" data-target="#mes" data-toggle="collapse"> Mes
                    </label>
                    </div>
                    <div class="btn-group btn-group-lg mr-2" role="group" >
                    <label class="btn btn-secondary">
                        <input type="radio" required name="tipo" <?=isset($this->viewBag->data['tipo'])?($this->viewBag->data['tipo']=='dia'?'checked':''):''?> onchange="selectedFilter()" value="dia" autocomplete="off"  data-target="#dia" data-toggle="collapse" > Dia
                    </label>
                    </div>
                    <div class="btn-group btn-group-lg mr-2 " role="group" >
                    <label class="btn btn-secondary">
                        <input type="radio" required name="tipo" <?=isset($this->viewBag->data['tipo'])?($this->viewBag->data['tipo']=='rango'?'checked':''):''?> onchange="selectedFilter()" value="rango" autocomplete="off"  data-target="#rango" data-toggle="collapse"> Rango de fecha
                    </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Tipo de reporte:</label>
                    <select name="filtro" required id="filtro" class="custom-select">
                        <option value="">Seleccione un tipo</option>
                        <option value="entrega">Entrega</option>
                        <option value="articulo">Articulo</option>
                        <option value="impresora">Impresora</option>
                    </select>
                    <span class="invalid-feedback">Por favor, selecciona un tipo de reporte</span>
                </div>
                            
                <div class="form-group collapse" id='mes' data-parent="#accordion">
                    <label>Mes:</label>
                    <input type="month" class="form-control" name="mes" placeholder="dd/mm/yyyy" >
                    <span class="invalid-feedback">Por favor, selecciona un mes</span>
                </div>
                <div class="form-group collapse " id='dia' data-parent="#accordion">
                    <label>Dia:</label>
                    <input type="date" class="form-control" name="dia" placeholder="dd/mm/yyyy">
                    <span class="invalid-feedback">Por favor, selecciona un dia</span>
                </div>
                <div class="form-group collapse" id='rango' data-parent="#accordion">
                    <label>Desde:</label>
                    <input type="date" class="form-control" name="desde" placeholder="dd/mm/yyyy">
                    <label>Hasta:</label>
                    <input type="date" class="form-control" name="hasta" placeholder="dd/mm/yyyy">
                    <span class="invalid-feedback">Por favor, selecciona un rango de fecha</span>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" value="Reporte" name="accion" class="btn btn-outline-info">Previsualizar &raquo;</button>
            </div>
        </form>
        <div class="alert alert-light border-left" data-target='#impresora' data-toggle="collapse" role="button">Generar reportes de impresoras</div>
        <form action="reporte.php" class="m-auto needs-validation collapse <?=isset($this->viewBag->data['tipoImpresora'])?'show':''?> <?=isset($this->viewBag->data['error']['impresora'])?'was-validated':''?>" method="post" id='impresora' novalidate data-parent='#all'>
            <div class="accordion" id="accordion_impresora">
                <div class="btn-toolbar mb-3 btn-group-toggle" role="toolbar" data-toggle="buttons">
                    <div class="btn-group btn-group-lg mr-2" role="group" >
                    <label class="btn btn-secondary">
                        <input type="radio" required name="tipoImpresora" <?=isset($this->viewBag->data['tipo'])?($this->viewBag->data['tipoImpresora']=='estado'?'checked':''):'checked'?> onchange="selectedFilter()" value="estado" id="" autocomplete="off" data-target="#estado" data-toggle="collapse"> Estado
                    </label>
                    </div>
                    <div class="btn-group btn-group-lg mr-2" role="group" >
                    <label class="btn btn-secondary">
                        <input type="radio" required name="tipoImpresora" <?=isset($this->viewBag->data['tipoImpresora'])?($this->viewBag->data['tipoImpresora']=='fechaentrada'?'checked':''):''?> onchange="selectedFilter()" value="fechaentrada"  autocomplete="off"  data-target="#fechaentrada" data-toggle="collapse" > Fecha de entrada
                    </label>
                    </div>
                    <div class="btn-group btn-group-lg mr-2 " role="group" >
                    <label class="btn btn-secondary">
                        <input type="radio" required name="tipoImpresora" <?=isset($this->viewBag->data['tipoImpresora'])?($this->viewBag->data['tipoImpresora']=='fechacompra'?'checked':''):''?> onchange="selectedFilter()" value="fechacompra" autocomplete="off"  data-target="#fechacompra" data-toggle="collapse"> Fecha de compra
                    </label>
                    </div>
                    <div class="btn-group btn-group-lg mr-2 " role="group" >
                    <label class="btn btn-secondary">
                        <input type="radio" required name="tipoImpresora" <?=isset($this->viewBag->data['tipoImpresora'])?($this->viewBag->data['tipoImpresora']=='marca'?'checked':''):''?> onchange="selectedFilter()" value="marca" id="option1" autocomplete="off"  data-target="#marca" data-toggle="collapse"> Marca
                    </label>
                    </div>
                </div>
                <div class="form-group collapse"  id="estado" data-parent="#accordion_impresora">
                    <label>Estado de impresora:</label>
                    <select name="idEstado" class="custom-select">
                        <option value="">Seleccione un estado</option>
                        <?php foreach($this->viewBag->estados as $row){?>
                            <option value="<?=$row->idEstado?>"><?=$row->estado?></option>
                        <?php }?>
                    </select>
                    <span class="invalid-feedback">Por favor, selecciona un estado</span>
                </div>
                <div class="form-group collapse" id='fechaentrada' data-parent="#accordion_impresora">
                    <label>Desde:</label>
                    <input type="date" class="form-control" name="desdefe" placeholder="dd/mm/yyyy">
                    <label>Hasta:</label>
                    <input type="date" class="form-control" name="hastafe" placeholder="dd/mm/yyyy">
                    <span class="invalid-feedback">Por favor, selecciona un rango de fecha</span>
                </div>
                <div class="form-group collapse" id='fechacompra' data-parent="#accordion_impresora">
                    <label>Desde:</label>
                    <input type="date" class="form-control" name="desdefc" placeholder="dd/mm/yyyy">
                    <label>Hasta:</label>
                    <input type="date" class="form-control" name="hastafc" placeholder="dd/mm/yyyy">
                    <span class="invalid-feedback">Por favor, selecciona un rango de fecha</span>
                </div>
                <div class="form-group collapse" id="marca" data-parent="#accordion_impresora">
                    <label>Marca de impresora:</label>
                    <select name="idMarca"  class="custom-select">
                        <option value="">Seleccione una marca</option>
                        <?php foreach($this->viewBag->marcas as $row){?>
                            <option value="<?=$row->idMarca?>"><?=$row->marca?></option>
                        <?php }?>
                    </select>
                    <span class="invalid-feedback">Por favor, selecciona una marca</span>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-5">
                <button type="submit" value="Reporte" name="accion" class="btn btn-outline-info">Previsualizar &raquo;</button>
            </div>
        </form>
        </div>
    </div>
</div>