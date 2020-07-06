<?php require_once('views/layouts/header.php'); ?>
<div class="container">
    <div class=" row align-items-center vh-100 justify-content-center ">
        <div class="card">
            <div class="card-header bg-white text-center">
                Inicio de Sesion
            </div>
            <div class="card-body">
                <div class="row  justify-content-center">
                    <img class="img-fluid" src="<?php echo constant('URL') ?>public/img/imgces.jpg" width="340" height="200">
                </div>
                <h5 class="card-title text-center justify-text-center my-3">Comite de Evaluacion y Seguimiento</h5>
                <div class="row justify-content-center">
                    <div class="col-10">
                        <form id="form">
                            <div class="form-group">
                                <label>Correo Electronico </label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="example@.com">
                                <div class="invalid-feedback" id="email-error"></div>
                            </div>

                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" name="password" id="password">
                                    <div class="input-group-append">
                                        <button class="btn btn-link border" type="button" id="showHide"><i class="far fa-eye-slash" id="icon"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2 ml-2">
                                <a href="#">Olvide mi contraseña</a>
                            </div>

                            <div class="row justify-content-center p-4">
                                <input id="btnLogin" type="submit" class="btn btn-primary" value="Iniciar Sesión">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('views/layouts/footer.php') ?>