<?php
    $marca = $this->viewBag->data[0]->marca;
    $marca = strtolower($marca);
?>
<div class="jumbotron ml-2 mr-2 overflow-auto">
    <h1 class="display-4">
        <?=$this->viewBag->data[0]->marca;?>
    </h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
            <li class="breadcrumb-item"><a href="marca.php">Marcas</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$this->viewBag->data[0]->marca;?></li>
        </ol>
    </nav>
</div>
<main class="w-100">
<div class="container w-75">
<div class="table-responsive">
  <table class="table table-hover">
    <thead>
        <tr scope="row">
            <th scope="col"> Modelo</th>
            <th scope="col"> Articulo</th>
            <th scope="col">Categoria</th>
        </tr>
    </thead>
    <tbody>    
      <?php
            if($this->viewBag->children == null){
                echo<<<input
                    <tr scope="row" >
                        <td scope="col" colspan="3" class="text-center">
                            <span class="display-4 text-muted">No existen registros</span>
                        </td>
                    </tr>
                input;
            }
            else
            foreach($this->viewBag->children as $row){
                $page = 'articulo';
                $isPrinter = trim(strtolower($row->tipoArticulo),'s') == 'impresora';
                if($isPrinter){
                    $page='impresora';
                }
                echo <<<input
                    <tr scope="row">
                        <td scope="col">
                            <a href="{$page}.php?id={$row->idArticulo}" class="text-decoration-none">{$row->modelo}</a>
                        </td>
                        <td scope="col">
                            <a href="tipoarticulo.php?id={$row->idTipoArticulo}" class="text-decoration-none">{$row->tipoArticulo}</a>
                        </td>
                        <td scope="col">
                            <a href="categoria.php?id={$row->idCategoria}" class="text-decoration-none">{$row->categoria}</a>
                        </td>
                    </tr>                    
                input;
            }
      ?>
     </tbody>
  </table>
</div>
</div>

</main>
