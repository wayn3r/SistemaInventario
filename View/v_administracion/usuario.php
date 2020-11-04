<div class="col-12">
    <div class="jumbotron ml-2 mr-2 overflow-auto">
        <h1 class="display-4">Todos los usuarios</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item"><a href="administracion.php">Administración</a></li>
                <li class="breadcrumb-item active" aria-current="page">Todos los usuarios</li>
            </ol>
        </nav>
    </div>
    <div class="col-10 m-auto">
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th scope="col">#</th>
            <th scope="col">Nombre completo</th>
            <th scope="col">Nombre de usuario</th>
            <th scope="col">Rol</th>
            <th scope="col">Fecha de creación</th>
            <th></th>
        </tr>
    </thead>
    <tbody>    
      <?php
            if($this->viewBag->data != null){
                foreach($this->viewBag->data as $row){?>
                    <tr scope="row">
                        <td scope="col">
                            <?=$row->idUsuario?>
                        </td>
                        <td scope="col">
                            <?=$row->nombreCompleto?>
                        </td>
                        <td scope="col">
                           <?=$row->user?>
                        </td>
                        <td scope="col">
                           <?=$row->rol?>
                        </td>
                        <td scope="col">
                           <?=$row->fechaCreacion?>
                        </td>
                        <td scope="col">
                            <a href="usuario.php?id=<?=$row->idUsuario?>" class="badge badge-pill btn-outline-info">Ver cuenta de usuario</a>
                            <a href="perfil.php?id=<?=$row->idPerfil?>" class="badge badge-pill btn-outline-info">Ver perfil</a>
                        </td>
                    </tr>                    
                  
              <?php  }}else{?>
                    <tr scope="row" >
                        <td scope="col" colspan="4" class="text-center">
                            <span class="display-4 text-muted">No existen usuarios</span>
                        </td>
                    </tr>
          <?php }
      ?>
     </tbody>
  </table>
</div>
</div>
</div>