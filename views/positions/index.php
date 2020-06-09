<?php require('views/layouts/header.php') ?>
<?php require('views/partials/navbar.php') ?>
<div class="container my-5">
    <div class="row">
        <div class="col">
            <h3>Cargos</h3>
        </div>
        <div class="col-2 text-md-right">
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Opciones
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Agregar</a>
                    <a class="dropdown-item" href="#" id="update">Actualizar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3" id="data-positions">
        
    </div>
</div>
<?php require('views/layouts/footer.php') ?>