<div class="col-12">
    <div class="col-11 col-sm-10 col-md-8 col-lg-5 pt-5 pb-5  m-auto">
    <?php
        if(isset($_GET['id']))
            $this->viewBag->data[0]['id'] = $_GET['id'];
        $isFromAdmin = isset($this->viewBag->data[0]['id']) && is_numeric($this->viewBag->data[0]['id']) && $this->sesion->IsAdmin() && $this->viewBag->data[0]['id'] > 0;
     if($isFromAdmin){?>
        <a href="administracion.php?accion=User" class="pt-2 pb-2">&laquo; Volver a todos los usuarios</a>
    <?php }?>
    <div class="card " id="user-card">
        <div class="card-header">
            <div class="card-title">
                <span class="h4">Información de esta cuenta de usuario</span>
            </div> 
        </div>
        <div class="card-body">
            <span class="text-danger"><?=isset($this->viewBag->error)?$this->viewBag->error:''?></span>
            <div class="row">
                <label class="col-5" for="user">Nombre de usuario:</label>
                <span class="h5 col-7" id="user-s"><?=$this->viewBag->data[0]['user']?></span>
            </div>
            <div class="row">
                <label class="col-5" for="pass">Contraseña:</label>
                <span class="h5 col-7" id="pass-s">**********</span>
            </div>
            <div class="row">
                <label class="col-5" for="user">Rol de usuario:</label>
                <span class="h5 col-7" id="user-s"><?=$this->viewBag->data[0]['rol']?></span>
            </div>
            <div class="row mt-3 collapse" id="edit-user" data-parent="#user-card">
                <div class="w-100 bg-light p-3">
                    <span class="h6">Editar nombre de usuario</span>
                </div>
                <form action="usuario.php" class="needs-validation col-12" method="post" novalidate>
                <input value="<?=$this->viewBag->data[0]['idUsuario']?>" name="idUsuario" hidden required>
                    <div class="form-group">
                        <label for="user">Nombre de usuario:</label>
                        <input type="text" value="<?=$this->viewBag->data[0]['user']?>" name="user" class="form-control" id="user" placeholder="Escriba un nombre de usuario" required>
                        <small class="invalid-feedback">Por favor, escriba un nombre de usuario</small>
                    </div>
                    <?php  if($isFromAdmin){?>
                        <div class="form-group" >
                        <label for="idRol">Rol:</label>
                        <select  name="idRol" class="custom-select" required>
                        <option value="">Seleccione su rol</option>
                        <?php if(isset($this->viewBag->roles)){
                            foreach($this->viewBag->roles as $row){?>
                            <option value="<?=$row->idRol?>" <?=$row->idRol == $this->viewBag->data[0]['idRol']?'selected':''?>><?=$row->rol?></option>
                            <?php }}?>
                        </select>
                        <span class="invalid-feedback">Por favor,selecione su rol</span>
                        
                    </div>
                    <?php }?>
                    
                    <hr/>
                    <div class="form-group">
                        <label for="pass-gc-eu">Contraseña:</label>
                        <input type="password" name="pass-gc" class="form-control" id="pass-gc-eu" placeholder="Escriba su contraseña para guardar cambios" required>
                        <small class="invalid-feedback">Es necesario ingresar su contraseña para guardar los cambios</small>
                    </div>
                    <div class="form-group">
                        <?php if($isFromAdmin){?>
                            <input hidden type="text" name="id" value="<?=$this->viewBag->data[0]['id']?>">
                        <?php }?>
                        <button type="submit" value="Edit" class="btn btn-success" name="accion">Guardar cambios</button>
                    </div>
                </form>
            </div>

            <div class="row mt-3 collapse" id="edit-pass" data-parent="#user-card">
                <div class="w-100 bg-light p-3">
                    <span class="h6">Editar contraseña</span>
                </div>
                <form action="usuario.php" class="needs-validation col-12" method="post" novalidate>
                    <input value="<?=$this->viewBag->data[0]['idUsuario']?>" name="idUsuario" hidden required>
                    <div class="form-group">
                        <label for="pass">Nueva contraseña:</label>
                        <input type="password" name="pass" class="form-control" id="pass" placeholder="Escriba nueva contraseña" required>
                        <small class="invalid-feedback">Por favor, escriba una contraseña</small>
                    </div>
                    <div class="form-group">
                        <label for="pass2">Confirmar contraseña:</label>
                        <input type="password" name="pass2" class="form-control" id="pass2" placeholder="Confirmar contraseña" required>
                        <small class="invalid-feedback">Este campo debe coincidir con la nueva contraseña</small>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <?php if($isFromAdmin){?>
                            <input hidden type="text" name="id" value="<?=$this->viewBag->data[0]['id']?>">
                        <?php }?>
                        <label for="pass-gc-ep">Antigua contraseña:</label>
                        <input type="password" name="pass-gc" class="form-control" id="pass-gc-ep" placeholder="Escriba su contraseña anterior" required>
                        <small class="invalid-feedback">Es necesario ingresar su contraseña anterior para guardar los cambios</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" value="Edit" class="btn btn-success" name="accion">Guardar cambios</button>
                    </div>
                </form>
            </div>
            <div class="row mt-3 collapse" id="remove-user" data-parent="#user-card">
                <div class="w-100 bg-light p-3">
                    <span class="h6">Eliminar cuenta de usuario</span>
                </div>
                <form action="usuario.php" class="needs-validation col-12" method="post" novalidate>
                    <input value="<?=$this->viewBag->data[0]['idUsuario']?>" name="id" hidden required>
                    <div class="alert alert-light">¿Estas seguro/a? Si continuas no podras volver a utilizar el  correo electrónico utilizado en esta cuenta para registrarte. ¿Deseas continuar?</div>
                    <hr/>
                    <div class="form-group">
                        <label for="pass-gc-ru">Contraseña:</label>
                        <input type="password" name="pass" class="form-control" id="pass-gc-reu" placeholder="Escriba su contraseña anterior" required>
                        <small class="invalid-feedback">Es necesario ingresar su contraseña para confirmar esta acción</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" value="Remove" class="btn btn-danger" name="accion">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end flex-wrap">
            <a href="#edit-user" data-toggle="collapse" class="badge badge-pill btn-outline-info">Editar usuario</a>
            <a href="#edit-pass" data-toggle="collapse" class="badge badge-pill btn-outline-info">Editar contraseña</a>
            <a href="#remove-user" data-toggle="collapse" class="badge badge-pill btn-outline-danger">Eliminar cuenta</a>
        </div>
    </div>
    </div>
</div>