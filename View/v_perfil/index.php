<div class="col-12">
    <div class="col-11 col-sm-10 col-md-8 col-lg-5 pt-5 pb-5  m-auto">
    <?php
        if(isset($_GET['id']))
            $this->viewBag->editar['id'] = $_GET['id'];
        $isFromAdmin = isset($this->viewBag->editar['id']) && is_numeric($this->viewBag->editar['id']) && $this->sesion->IsAdmin() && $this->viewBag->editar['id']>0;
     if($isFromAdmin){?>
        <a href="administracion.php?accion=User" class="pt-2 pb-2">&laquo; Volver a todos los usuarios</a>
    <?php }?>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <span class="h4">Información de perfil de usuario</span>
            </div> 
        </div>
        <div class="card-body">
            <div class="row">
                <label class="col-5" for="nombre-s">Nombre: </label>
                <span class="h5 col-7" id="nombre-s"><?=$this->viewBag->data[0]['nombre']?></span>
            </div>
            <div class="row">
                <label class="col-5" for="apellido-s">Apellido:</label>
                <span class="h5 col-7" id="apellido-s"><?=$this->viewBag->data[0]['apellido']?></span>
            </div>
            <div class="row">
                <label class="col-5" for="correo-s">Correo:</label>
                <span class="h5 col-7" id="correo-s"><?=$this->viewBag->data[0]['correo']?></span>
            </div>
            <div class="row">
                <label class="col-5" for="localidad-s">Localidad:</label>
                <span class="h5 col-7" id="localidad-s"><?=$this->viewBag->data[0]['localidad']?></span>
            </div>
            <div class="row">
                <label class="col-5" for="localidad-s">Departamento:</label>
                <span class="h5 col-7" id="localidad-s"><?=$this->viewBag->data[0]['departamento']?></span>
            </div>
            <div class="row">
                <label class="col-5" for="localidad-s">Fecha de Creación:</label>
                <span class="h5 col-7" id="localidad-s"><?=$this->viewBag->data[0]['fechaCreacion']?></span>
            </div>
            <div class="row mt-3 collapse <?=isset($this->viewBag->error)?'show':''?>" id="edit-perfil">
                <div class="w-100 bg-light p-3">
                    <span class="h6">Editar perfil</span>
                </div>
                <span class="text-danger pl-3 pb-2"><?=isset($this->viewBag->error)?$this->viewBag->error:''?></span>
                <form action="perfil.php" class="needs-validation col-12 <?=isset($this->viewBag->error)?'was-validated':''?>" method="post" novalidate>
                    <input hidden value="<?=$this->viewBag->editar['idPerfil']?>" name="idPerfil" required>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" value="<?=$this->viewBag->editar['nombre']?>" class="form-control" id="nombre" placeholder="Escriba su nombre" required>
                        <small class="invalid-feedback">Por favor, escriba un nombre</small>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido:</label>
                        <input type="text" name="apellido" value="<?=$this->viewBag->editar['apellido']?>" class="form-control" id="apellido" placeholder="Escriba su apellido" required>
                        <small class="invalid-feedback">Por favor, escriba un apellido</small>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" id="correo" class="form-control" placeholder="Escriba su correo" value="<?=$this->viewBag->editar['correo']?>">
                        <small class="invalid-feedback">Por favor, escriba su correo</small>
                    </div>
                    <div class="form-group" >
                        <input hidden name="idLocalidad" value="<?=$this->viewBag->editar['idLocalidad'].'%&'.$this->viewBag->editar['localidad']?>">
                        <label for="localidad">Localidad:</label>
                        <input type="text" list="localidades" name="localidad" class="form-control" placeholder="Escriba su localidad" value="<?=$this->viewBag->editar['localidad']?>" required>
                        <span class="invalid-feedback">Por favor, escriba o selecione su localidad</span>
                        <?php if(isset($this->viewBag->localidades)){?>
                            <datalist id="localidades">
                                <?php foreach($this->viewBag->localidades as $row){?>
                                <option value="<?=$row->localidad?>"></option>
                                <?php }?>
                            </datalist>
                            <?php }?>
                    </div>
                    <div class="form-group" >
                        <label for="idDepartamento">Departamento:</label>
                        <select  name="idDepartamento" class="custom-select" required>
                        <option value="">Seleccione su departamento</option>
                        <?php if(isset($this->viewBag->departamentos)){
                            foreach($this->viewBag->departamentos as $row){?>
                            <option value="<?=$row->idDepartamento?>" <?=$row->idDepartamento == $this->viewBag->editar['idDepartamento']?'selected':''?>><?=$row->departamento?></option>
                            <?php }}?>
                        </select>
                        <span class="invalid-feedback">Por favor,selecione su departamento</span>
                        
                    </div>
                    <hr/>
                    <div class="form-group">
                        <?php if($isFromAdmin){?>
                            <input hidden type="text" name="id" value="<?=$this->viewBag->editar['id']?>">
                        <?php }?>
                        <label for="pass">Contraseña:</label>
                        <input type="password" name="pass-gc" class="form-control" id="pass" placeholder="Escriba su contraseña para guardar cambios" required>
                        <small class="invalid-feedback">Es necesario ingresar su contraseña para guardar los cambios</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" value="Edit" class="btn btn-success" name="accion">Guardar cambios</button>
                    </div>
                </form>
            </div>
            
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a href="#edit-perfil" data-toggle="collapse" class="badge badge-pill btn-outline-info">Editar perfil</a>
        </div>
    </div>
    </div>

</div>