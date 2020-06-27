<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h4>Dashboard</h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <div class="jumbotron bg-default">
                <h1 class="display-5">Bievenido <span class="text-primary"><?php echo $this->user['name']; ?></span></h1>
                <p class="lead">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nisi eaque esse eligendi vero eius quo pariatur! In, nisi quasi. Provident cumque maxime nobis earum voluptate quas soluta labore molestiae ab..</p>
                <hr class="my-4">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Gestiona tus recursos</div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="<?php echo constant('URL') ?>positions" class="list-group-item list-group-item-action">Cargos</a>
                                    <a href="<?php echo constant('URL') ?>learners" class="list-group-item list-group-item-action">Aprendices</a>
                                    <a href="<?php echo constant('URL') ?>contract_types" class="list-group-item list-group-item-action">Tipos de contratos</a>
                                    <a href="<?php echo constant('URL') ?>document_types" class="list-group-item list-group-item-action">Tipos de documentos</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <div class="card">
                            <div class="card-header bg-primary text-white">Relacionados con la formacion</div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="<?php echo constant('URL') ?>groups" class="list-group-item list-group-item-action">
                                        Grupos
                                    </a>
                                    <a href="<?php echo constant('URL') ?>modalities" class="list-group-item list-group-item-action">Modalidades</a>
                                    <a href="<?php echo constant('URL') ?>formation_programs" class="list-group-item list-group-item-action">Programas de formacion</a>
                                    <a href="<?php echo constant('URL') ?>formation_program_types" class="list-group-item list-group-item-action">Tipos de programas de formacion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                    <div class="card">
                            <div class="card-header bg-primary text-white">Vamos a comité</div>
                            <div class="card-body">
                                <div class="list-group">
                                    <a href="<?php echo constant('URL') ?>formative_measure_responsibles" class="list-group-item list-group-item-action">Responsables</a>
                                    <a href="<?php echo constant('URL') ?>committee_session_types" class="list-group-item list-group-item-action">Tipos de casos</a>
                                    <a href="<?php echo constant('URL') ?>committees" class="list-group-item list-group-item-action">Reuniones de comite</a>
                                    <a href="<?php echo constant('URL') ?>learner_novelties" class="list-group-item list-group-item-action">Novedades del aprendiz</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once('views/layouts/footer.php') ?>