<?php require('views/layouts/header.php') ?>
<?php require('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h3>Casos de este comité</h3>
            <input type="hidden" id="committee_id" value="<?php echo $this->committee->id ?>">
            <p class="text-muted">Numero de acta: <span class="text-dark"><?php echo $this->committee->record_number; ?></span></p>
        </div>
    </div>
    <div id="loader"></div>
    <div class="row mt-3">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Aprendiz</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="data-academics">

                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal" id="modal-history" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Historial del aprendiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#information" role="tab" aria-controls="home" aria-selected="true">Aprendiz</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Novedades</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Estimulos</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Academico/Disciplinario</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show pt-2" id="information" role="tabpanel" aria-labelledby="home-tab">

                    </div>
                    <div class="tab-pane fade show pt-2" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Novedad</th>
                                            <th>Justificacion</th>
                                            <th>Fecha de respuesta</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-novelties">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade pt-2" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Estimulo</th>
                                            <th>Justificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-stimuli">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="row">
                            <div class="col">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Estimulo</th>
                                            <th>Justificacion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-academics">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal communication -->
<div class="modal" id="modal-communication" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Acta de comunicacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-communication">
                    <input type="hidden" name="committee_id" id="committee_id">
                    <input type="hidden" name="learner_id" id="learner_id">
                    <div class="form-group">
                        <label for="">Relacion suscinta del informe o de la queja presentada</label>
                        <textarea name="acts" id="acts" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Normas del reglamento que el aprendiz infringio</label>
                        <textarea name="infringements" id="infringements" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Tipo de falta</label>
                        <div id="infringement_types"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Clasificacion provisional de la falta</label>
                        <div id="infringement_classifications"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="form-communication" class="btn btn-primary">Generar</button>
            </div>
        </div>
    </div>
</div>

<?php require('views/layouts/footer.php') ?>