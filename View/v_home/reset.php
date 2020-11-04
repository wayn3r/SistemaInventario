<div class="container mt-5">
    <form accion="home.php" method="post" class="needs-validation col-11 col-md-6 m-auto " novalidate>
        <div class="alert alert-light border-left">
            <h1 class="h3">Reestablecer mi contraseña</h1>
        </div>
        <div class="form-group">
            <span class="h3">Ya estamos terminando, <?=$this->viewBag->data['user']?>!</span>
        </div>    
        <div class="form-group <?=isset($this->viewBag->error)?'was-validated':''?>">
            <label for="">Nueva contraseña:</label>
            <input type="password" name="pass" class="form-control" placeholder="Escriba una nueva contraseña" required>
            <span class="invalid-feedback"><?=isset($this->viewBag->error)?$this->viewBag->error:'Por favor, escriba una contraseña'?></span>
        </div>
        <div class="form-group" >
            <label for="">Confirmar contraseña:</label>
            <input type="password" name="pass2" class="form-control" placeholder="Escriba una nueva contraseña" required>
            <span class="invalid-feedback">Por favor, confirma tu contraseña</span>
        </div>
        <div class="d-flex justify-content-between mt-3">
            <a href="home.php">&laquo; Volver al login</a>
            <input hidden value="1" name="reset" required>
            <button type="submit" value="Reset" name="accion" class="btn btn-success">Reestablecer</button>
        </div>
    </form>
</div>