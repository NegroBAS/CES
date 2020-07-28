<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-8 col-md-10">
            <h4>Reportes</h4>
        </div>
    </div>
    <div class="row mt-3" id="data">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4>Novedades</h4>
                    <p>Cuantos y cuales estudiantes reportaron alguna novedad este año</p>
                    <a href="<?php echo constant('URL') ?>reports/learner_novelties" class="btn btn-outline-primary">Detalle</a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4>Recomendados para estimulos</h4>
                    <p>Estudiantes que por su buen comportamiento y desempeño no hay estado en comité</p>
                    <a href="<?php echo constant('URL') ?>reports/stimuli_recommended" class="btn btn-outline-primary">Detalle</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('views/layouts/footer.php') ?>