<div class="container mt-5">
    <?php if(isset($this->viewBag->mail)){?>
        <div class="alert alert-success mb-3">
            <span>Necesitamos confirmar tu identidad continuar el proceso. Hemos enviado un correo electrónico a esta direción de correo: <strong><?=$this->viewBag->mail?>.</strong></span>
        </div>
    <?php }?>
    <form accion="home.php" method="post" class="needs-validation col-11 col-md-6 m-auto " novalidate>
        <div class="alert alert-light border-left">
            <h1 class="h3">Olvide mi contraseña</h1>
        </div>    
        <div class="form-group" >
            <label for="">Nombre de usuario o correo electrónico:</label>
            <input type="text" value="<?=isset($this->viewBag->user)?$this->viewBag->user:''?>" name="user" class="form-control  <?=isset($this->viewBag->error)?'is-invalid':''?>" placeholder="Escriba su nombre de usuario o correo electrónico" required onkeydown="removeValidation(this)">
            <span class="invalid-feedback"><?=isset($this->viewBag->error)?$this->viewBag->error:'Por favor, escriba su nombre de usuario o correo electrónico'?></span>
        </div>
        <small class="text-muted ">Si olvidaste tu contraseña enviaremos un correo electrónico, a la dirección de correo con la que te registraste. Revisa tu bandeja de correo para reiniciar tu contraseña.</small>
        <div class="d-flex justify-content-between mt-3">
            <a href="home.php">&laquo; Volver al login</a>
            <button type="submit" value="Pass" name="accion" class="btn btn-success">Enviar correo</button>
        </div>
    </form>
</div>