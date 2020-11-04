<div class="col-12">
    <div class="jumbotron ml-2 mr-2">
        <h1 class="display-4">Historico</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item"><a href="historico.php">Historico</a></li>
                <li class="breadcrumb-item active" aria-current="page">Articulos</li>
                <li class="breadcrumb-item active" aria-current="page"><?=$this->viewBag->fecha['fecha']?></li>
            </ol>
        </nav>
    </div>
    <div class="col-10 m-auto p-2 d-flex justify-content-between">
        <a href="historico.php">&laquo; Voler a la historico</a>
        <a href="historico.php?id=<?=$this->viewBag->fecha['idFecha']?>&accion=Historico&tipo=impresora">Ver impresoras para esta fecha</a>
    </div>
    <div class="table-responsive col-10 m-auto">
    <table class="table table-hover">
        <thead>
            <tr scope="row">
                <th scope="col">Fecha inventario</th>
                <th scope="col">Fecha compra</th>
                <th scope="col">Categoria</th>
                <th scope="col">Articulo</th>
                <th scope="col">Marca</th>
                <th scope="col">Modelo</th>
                <th scope="col">Cantidad contada</th>
                <th scope="col">Cantidad en stock</th>
            </tr>
        </thead>
    <?php if(count($this->viewBag->data) > 0){
        foreach($this->viewBag->data as $row){?>
        <tr scope="row">
            <td scope="col"><?=$row->fechaInventario?></td>
            <td scope="col"><?=$row->fechaCompra?></td>
            <td scope="col"><?=$row->categoria?></td> 
            <td scope="col"><?=$row->tipoArticulo?></td> 
            <td scope="col"><?=$row->marca?></td>
            <td scope="col"><?=$row->modelo?></td>
            <td scope="col"><?=$row->cantidadContada?></td>
            <td scope="col"><?=$row->cantidadStock?></td>
        </tr>                        
    <?php }}else{?>
        <tr scope="row">
            <td scope="col" colspan="8" class="text-center">
                <span class="display-4 text-muted ">No existen registros</span>
            </td>
        </tr>
    <?php }?>
    <tfoot>
        <tr>
            <td scope="col" colspan="8">
                <span class="text-muted">Registro de inventario de los articulos existentes para la fecha <?=$this->viewBag->fecha['fecha']?></span>
            </td>
        </tr>
    </tfoot>
    </table>        
    </div>
</div>