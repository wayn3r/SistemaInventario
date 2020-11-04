    <div class="container-md ">  
        <div class="row justify-content-around h-75 ">
            <div class="col-12 col-md-5">   
                <div style="top:50px;" class="row position-sticky">
                    <img src="../img/fondo-login.jpg" class="img-fluid col-10 m-auto" alt="Ron Barcelo" >
                </div>
            </div>
            
            <div class="col-12 col-md-5 mt-4">
                <!-- LOGIN -->
                <div class="row justify-content-center">
                    <div class="card shadow-sm w-75">  
                        <div class="card-header">
                            <h3>Login</h3>
                        </div>
                        <div class="card-body">  
                            <form method="post" class="needs-validation <?=isset($this->viewBag->login['error']['pass'])?'was-validated':''?>" novalidate>
                                <div class="form-group">
                                    <label for="user">Nombre de usuario</label>
                                    <input type="text" class="form-control <?=isset($this->viewBag->login['error']['user'])?'is-invalid':''?>" id="user" name="user" value="<?=isset($this->viewBag->login['user'])?$this->viewBag->login['user']:''?>" placeholder="Ingrese su nombre de usuario" required>
                                    <span class="invalid-feedback"><?=isset($this->viewBag->login['error']['user'])?$this->viewBag->login['error']['user']:'Por favor, escriba su nombre de usuario'?></span>
                                </div>
                                <div class="form-group">
                                    <label for="pass">Contraseña</label>
                                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingrese su contraseña" required>
                                    <span class="invalid-feedback"><?=isset($this->viewBag->login['error']['pass'])?$this->viewBag->login['error']['pass']:'Por favor, escriba su contraseña'?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-info" value="Login" name="accion">Login</button>
                                
                                <div class="text-right">
                                   <a href="home.php?accion=Pass" ><span>Olvide mi contraseña</span></a>
                                </dv>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>                
            </div>
        </div>        
    </div>

