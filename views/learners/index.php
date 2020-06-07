<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h3>Aprendices</h3>
        </div>
        <div class="col-2 text-right">
            <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item">Agregar</a>
                <a href="#" class="dropdown-item">Subir Excel</a>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <table id="learners" class="table table-bordered">
                <thead>
                    <th>Nombre</th>
                    <th>Tipo de documento</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Correo electronico</th>
                    <th>Opciones</th>
                </thead>
                <tbody id="data-learners">

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once('views/layouts/footer.php') ?>