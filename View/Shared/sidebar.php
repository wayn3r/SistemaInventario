<div class="col-xl-2 col-lg-3 col-md-4 col-12 d-block navbar navbar-expand-md navbar-light alert-light overfow-auto p-2" id="sidebar"> 
    <div class="text-center m-2"><a href="#navbar" data-toggle="collapse" class="btn btn-outline-light navbar-toggler p-2" aria-controls="navbar" >Barra de navegación &dtrif;</a></div>

    <div style="top:65px;" class="navbar-collapse collapse pt-2 pb-3 border border-info rounded position-sticky" id="navbar">
        <ul class="nav flex-column accordion flex-grow-1 " id="side-bar" >
            <div class="">
            <a href="categoria.php" class="pl-3 text-decoration-none "><span class="text-muted">CATEGORIAS</span></a>
            <?php
                if(isset($this->viewBag->sideBar)){  
                    foreach($this->viewBag->sideBar['categorias'] as $categoria){?>

                    <li class="nav-item container-fluid" id="btn-accordion-categoria-<?=$categoria['idCategoria']?>">
                        <button class="btn btn-block container-fluid text-left collapsed" data-toggle="collapse" aria-expanded="false" data-target="#content-btn-categoria-<?=$categoria['idCategoria']?>" aria-controls="content-btn-categoria-<?=$categoria['idCategoria']?>">
                            <div class="w-75"><a href="categoria.php?id=<?=$categoria['idCategoria']?>" class="nav-link"> <strong class="text-dark"><?=$categoria['categoria']?></strong></a></div> 
                            <span class="h3">+</span>
                        </button>
                        <div class="collapse" id="content-btn-categoria-<?=$categoria['idCategoria']?>" aria-labelledby="btn-accordion-categoria-<?=$categoria['idCategoria']?>" data-parent="#side-bar">
                            <?php 
                            foreach($categoria['tipoArticulos'] as $tipoArticulo){
                                if($tipoArticulo['idTipoArticulo'] != null){
                            ?>
                            <a href="tipoarticulo.php?id=<?=$tipoArticulo['idTipoArticulo']?>" class="nav-link ">
                                <span class="text-muted pl-3"><?=$tipoArticulo['tipoArticulo']?></span>
                            </a>
                            <?php }else{ ?>
                                <span class='text-muted pl-3'>Sin registros</span>
                            <?php }}?>
                        </div>
                    </li>                                    
            <?php }}?>                        
            </div>
            <div class="mb-2 pb-2">
            <hr class="m-2">
            <a href="marca.php" class="pl-3 text-decoration-none"><span class="text-muted">MARCAS</span></a>
            <?php
                if(isset($this->viewBag->sideBar)){  
                    foreach($this->viewBag->sideBar['marcas'] as $marca){?>
                <li class="nav-item container-fluid" id="btn-accordion-marca-<?=$marca['idMarca']?>">
                    <button class="btn btn-block container-fluid text-left collapsed" data-toggle="collapse" aria-expanded="false" data-target="#content-btn-marca-<?=$marca['idMarca']?>" aria-controls="content-btn-marca-<?=$marca['idMarca']?>">
                        <div class="w-75"><a href="marca.php?id=<?=$marca['idMarca']?>" class="nav-link"> <strong class="text-dark"><?=$marca['marca']?></strong></a></div> 
                        <span class="h3">+</span>
                    </button>
                    <div class="collapse" id="content-btn-marca-<?=$marca['idMarca']?>" aria-labelledby="btn-accordion-marca-<?=$marca['idMarca']?>" data-parent="#side-bar">
                    <?php  foreach($marca['tipoArticulos'] as $tipoArticulo){
                        if($tipoArticulo['idTipoArticulo'] != null){?>
                        <a href="tipoarticulo.php?id=<?=$tipoArticulo['idTipoArticulo']?>" class="nav-link "> <span class="text-muted pl-3"><?=$tipoArticulo['tipoArticulo']?></span></a>
                        <?php }else{?>
                            <span class='text-muted pl-3'>Sin registros</span>
                    <?php }}?> 
                </div>
                </li>
            <?php }}?>                        
        </div>            
        </ul>             
    </div>

    
        
</div>

<div class="col-xl-10 col-lg-9 col-md-8 col-12" >