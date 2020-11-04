<main class="w-100">
<div class="jumbotron ml-2 mr-2">
    <h1 class="display-4">
       Entregas
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Entregas</li>
        </ol>
    </nav>
</div>
<div class="container w-75">
    <div class="row justify-content-between">
        <a href="correo.php" class="align-self-end m-2">Ver correos</a>
        <a href="entrega.php?accion=Entrega" class="btn btn-success m-2">Realizar entrega</a>
    </div>
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th scope="col">#</th>
            <th scope="col">Recibido Por</th>
            <th scope="col">Entregado Por</th>
            <th scope="col">Fecha de entrega</th>
            <th></th>
        </tr>
    </thead>
    <tbody>    
      <?php
            if($this->viewBag->data != null){
                foreach($this->viewBag->data as $row){?>
                    <tr scope="row">
                        <td scope="col">
                            <?=$row->idEntrega?>
                        </td>
                        <td scope="col">
                            <?=$row->recibidoPor?>
                        </td>
                        <td scope="col">
                           <?=$row->entregadoPor?>
                        </td>
                        <td scope="col">
                           <?=$row->fechaEntrega?>
                        </td>
                        <td scope="col">
                            <?php if($row->terminado == 1){?>
                                <a href="entrega.php?id=<?=$row->idEntrega?>" class="badge badge-pill btn-outline-info">Detalles</a>
                            <?php }else{?>
                                <a href="detalle.php?id=<?=$row->idEntrega?>" class="badge badge-pill btn-outline-success">Completar</a>
                            <?php }?>
                        </td>
                    </tr>                    
                  
              <?php  }}else{?>
                    <tr scope="row" >
                        <td scope="col" colspan="4" class="text-center">
                            <span class="display-4 text-muted">No existen registros</span>
                        </td>
                    </tr>
          <?php }
      ?>
     </tbody>
  </table>
</div>
</div>

</main>
