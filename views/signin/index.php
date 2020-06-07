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
                <h5 class="card-title text-center justify-text-center">Comite de Evaluacion y Seguimiento</h5>
                <div class="row justify-content-center">
                    <div class="col-10">
                        <form method="POST" action="#">
                            <label>Correo Electronico </label>
                            <input class="form-control" type="text" name="nombre" id="nombre" placeholder="example@.com">

                            <label>Contraseña</label>
                            <input class="form-control" type="password" name="contraseña" id="contraseña" placeholder="Contraseña">

                            <div class="row mt-2 ml-2">
                                <a href="#">Olvide mi contraseña</a>
                            </div>

                            <div class="row justify-content-center p-4">
                                <input type="submit" class="btn btn-primary " value="Iniciar Sesión">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once('views/layouts/footer.php') ?>