<?php
    
    $departamento = trim($this->viewBag->data[0]->departamento,'s,es');
    $departamento = strtolower($departamento);
?>
<main class="col-12">
    <div class="jumbotron ml-2 mr-2">

<h1 class="display-4">
    <?=$this->viewBag->data[0]->departamento;?>
</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item"><a href="departamento.php">Departamentos</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$this->viewBag->data[0]->departamento;?></li>
        </ol>
    </nav>
</div>
<div class="container">
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th scope="col">Codigo de Empleado</th>
            <th scope="col">Nombre</th>
            <th scope="col">Apellido</th>
            <th scope="col">Correo</th>
            <th scope="col">Estado</th>
            <th scope="col">Fecha de Entrada</th>
        </tr>
    </thead>
    <tbody>    
      <?php
            if($this->viewBag->children != null){
                foreach($this->viewBag->children as $row){ ?>
                    <tr scope="row">
                        <td scope="col">
                            <a href="empleado.php?id=<?=$row->idEmpleado?>" class="text-decoration-none"><?=$row->codigoEmpleado?></a>
                        </td>
                        <td scope="col">
                            <?=$row->nombre?>
                        </td>
                        <td scope="col">
                            <?=$row->apellido?>
                        </td>
                        <td scope="col">
                            <?=$row->correo?>
                        </td>
                        <td scope="col">
                            <?=$row->activo == 1?'Activo':'Inactivo'?>
                        </td>
                        <td scope="col">
                            <?=$row->fechaEntrada?>
                        </td>
                    </tr>                    
               <?php }}else{?> 
                    <tr scope="row" >
                        <td scope="col" colspan="6" class="text-center">
                            <span class="display-4 text-muted">No existen registros</span>
                        </td>
                    </tr>
               <?php }?>
     </tbody>
  </table>
</div>
</main>