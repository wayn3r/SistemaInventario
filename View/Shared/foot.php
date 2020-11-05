        <?php if(isset($this->sidebar)){?>
                    </div>
        <?php } ?>
    </div>      
</div>      

<?php if(isset($this->result) && !isset($this->result->noshow)){?>  
        <!-- ALERTA -->
    <div class="toast m-4 toast-positioned alert-<?=isset($this->result->color)?$this->result->color:'info'?>" role="alert" 
    aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header text-white bg-<?=isset($this->result->color)?$this->result->color:'info'?>">
            <strong class="mr-auto ">Sistema de Invetario</strong>
            <small ><?=isset($this->result->tiempo)?'hace '.$this->result->tiempo:'ahora'?></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body ">
            <span><?=isset($this->result->mensaje)?$this->result->mensaje:'Accion de ejemplo'?></span>
        </div>
    </div>
    <!-- FIN DE LA ALERTA -->
<?php } ?>  
 <!-- SCRIPTS -->
    <script src="../utils/js/jquery-3.5.1.min.js"></script>
    <script src="../utils/js/popper.min.js"></script>
    <script src="../utils/js/bootstrap.min.js"></script>
    <script src="../utils/js/Chart.min.js"></script>
    <script src="../utils/js/custom.js"></script> 

</body>
<footer class="container-fluid p-4 border-top text-center bg-light" style="position: fixed; bottom:0; z-index: 2;">
    <span class="h5 text-center">&copy;<?=date('Y');?> - Ron Barceló</span>
</footer>
</html>
<?php ob_flush(); ob_end_clean();?>