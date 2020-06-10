<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h4>Responsables de medidas formativas</h4>
        </div>
        <div class="col-2 text-right">
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
    <div class="row mt-3">
        <div class="col">
            <table class="table table-bordered" id="formative-measure-responsibles">
                <thead>
                    <th>Nombre</th>
                    <th>Correo Misena</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Opciones</th>
                </thead>
                <tbody id="data-formative-measure-responsible">

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once('views/layouts/footer.php') ?>