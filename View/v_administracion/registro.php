<div class="col-12">
    <div class="jumbotron ml-2 mr-2 overflow-auto">
        <h1 class="display-4">Registro de usuarios</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item"><a href="administracion.php">Administración</a></li>
                <li class="breadcrumb-item active" aria-current="page">Registro de usuarios</li>
            </ol>
        </nav>
    </div>
<!-- REGISTRO -->
<div class="col-10 m-auto pt-3">
<a href="administracion.php">&laquo; Volver a administración</a>
<div class="card shadow m-3" id="register">  
        <div class="card-header">
            <h3>Registro</h3>
        </div>
        <div class="card-body">  
            <form method="post" class="needs-validation row" action="administracion.php" novalidate>
                <div class="col-12 col-md-6 ">
                    <div class="alert bg-light border-left">
                        <span>Datos personales</span>
                    </div>
                    <div class="form-group <?=isset($this->viewBag->registro['error'])?'was-validated':''?>">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value= "<?=isset($this->viewBag->registro['nombre'])?$this->viewBag->registro['nombre']:''?>" placeholder="Escriba su nombre" required>
                        <span class="invalid-feedback">Por favor, escriba su nombre</span>
                    </div>
                    <div class="form-group <?=isset($this->viewBag->registro['error'])?'was-validated':''?>">
                        <label for="apellido">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value= "<?=isset($this->viewBag->registro['apellido'])?$this->viewBag->registro['apellido']:''?>" placeholder="Escriba su apellido" required>
                        <span class="invalid-feedback">Por favor, escriba su apellido</span>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo electronico:</label>
                        <input type="email" name="correo" class="form-control <?=isset($this->viewBag->registro['error']['correo'])?'is-invalid':''?>" placeholder="Escriba su correo electronico" value="<?=isset($this->viewBag->registro['correo'])?$this->viewBag->registro['correo']:''?>" required>
                        <span class="invalid-feedback"><?=isset($this->viewBag->registro['error']['correo'])?$this->viewBag->registro['error']['correo']:'Por favor, escriba un correo electronico valido'?></span>
                    </div>
                    <div class="form-group <?=isset($this->viewBag->registro['error'])?'was-validated':''?>">
                        <label for="localidad">Localidad:</label>
                        <input type="text" list="localidades" name="localidad" class="form-control" placeholder="Escriba su localidad" value="<?=isset($this->viewBag->registro['localidad'])?$this->viewBag->registro['localidad']:''?>" required>
                        <?php if(isset($this->viewBag->localidades)){?>
                            <datalist id="localidades">
                                <?php foreach($this->viewBag->localidades as $row){?>
                                <option value="<?=$row->localidad?>"></option>
                                <?php }?>
                            </datalist>
                        <?php }?>
                        <span class="invalid-feedback">Por favor, escriba o selecione su localidad</span>
                    </div>
                    <div class="form-group <?=isset($this->viewBag->registro['error'])?'was-validated':''?>">
                        <label for="">Departamento:</label>
                        <select class="custom-select" name="idDepartamento" value="" required>
                        <option value="">Seleccione su departamento</option>
                        <?php if(isset($this->viewBag->departamentos)){
                            foreach($this->viewBag->departamentos as $row){?>
                            <option value="<?=$row->idDepartamento?>" <?=(isset($this->viewBag->registro['idDepartamento']) && $this->viewBag->registro['idDepartamento'] == $row->idDepartamento)?'selected':''?> ><?=$row->departamento?></option>
                        <?php }}?>
                        </select>
                        <span class="invalid-feedback">Por favor, seleccione su departamento</span>
                    </div>
                </div>
                <div class="col-12 col-md-6 ">
                    <div class="alert bg-light border-left">
                        <span>Datos de cuenta de usuario</span>
                    </div>
                    <div class="form-group <?=isset($this->viewBag->registro['error']['correo'])?'was-validated':''?>">
                        <label for="user-r">Nombre de usuario:</label>
                        <input type="text" class="form-control <?=isset($this->viewBag->registro['error']['user'])?'is-invalid':''?>" id="user-r" name="user" value= "<?=isset($this->viewBag->registro['user'])?$this->viewBag->registro['user']:''?>" placeholder="Escriba un nombre de usuario" required>
                        <span class="invalid-feedback"><?=isset($this->viewBag->registro['error']['user'])?$this->viewBag->registro['error']['user']:'Por favor, escriba un nombre de usuario'?></span>
                    </div>
                    <div class="form-group <?=isset($this->viewBag->registro['error'])?'was-validated':''?>">
                        <label for="">Rol:</label>
                        <select class="custom-select" name="idRol" value="" required>
                        <option value="">Seleccione su rol</option>
                        <?php if(isset($this->viewBag->roles)){
                            foreach($this->viewBag->roles as $row){?>
                            <option value="<?=$row->idRol?>" <?=(isset($this->viewBag->registro['idRol']) && $this->viewBag->registro['idRol'] == $row->idRol)?'selected':''?> ><?=ucfirst($row->rol)?></option>
                        <?php }}?>
                        </select>
                        <span class="invalid-feedback">Por favor, seleccione su rol</span>
                    </div>
                    <div class="form-group <?=isset($this->viewBag->registro['error']['pass'])?'was-validated':''?>">
                        <label for="pass-r">Contraseña</label>
                        <input type="password" class="form-control" id="pass-r" name="pass" placeholder="Escriba una contraseña" required>
                        <span class="invalid-feedback"><?=isset($this->viewBag->registro['error']['pass'])?$this->viewBag->registro['error']['pass']:'Por favor, escriba su contraseña'?></span>
                    </div>
                    <div class="form-group">
                        <label for="pass2">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="pass2" name="pass2" placeholder="Confirme su contraseña" required>
                        <span class="invalid-feedback">Por favor, confirme su contraseña</span>
                    </div>
                    <div class="row mt-4 pr-0">
                        <div class="col-12 text-right">
                            <button type="submit" class="btn btn-success" name="accion" value="Signup">Sign up</button>
                        </div>
                        
                    </div>
                </div>              
            </form>
        </div>
    </div>
</div>
</div>