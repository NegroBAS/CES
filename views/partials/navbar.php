<nav class="navbar navbar-expand-lg navbar-light bg-white" style="box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)">
    <div class="container">
        <a class="navbar-brand" href="#"><?php echo constant('APPNAME'); ?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
                        Gestion
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>learners">Aprendices</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>positions">Cargos</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>contract_types">Tipos de contratos</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>document_types">Tipos de documentos</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
                        Formacion
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>groups">Grupos</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>modalities">Modalidades</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>formation_programs">Programas de formacion</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>formation_program_types">Tipos de programas de formacion</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
                        Comité
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>committees">Reuniones de comité</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>sanctions">Sanciones</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>committee_parameters">Parametros de comité</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>committee_session_types">Tipos de casos</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>formative_measures">Medidas formativas</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>infringement_types">Tipos de faltas</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>infringement_classifications">Clasificacion de las faltas</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>learner_novelties">Novedades del aprendiz</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>novelty_types">Tipos de novedades del aprendiz</a>
                        <a class="dropdown-item" href="<?php echo constant('URL') ?>formative_measure_responsibles">Responsables de medidas formativas</a>
                    </div>
                </li>
            </ul>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $this->user['name'] ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Perfil</a>
                            <a class="dropdown-item" href="<?php echo constant('URL') ?>users">Usuarios</a>
                            <a class="dropdown-item" href="<?php echo constant('URL') ?>rols">Roles</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo constant('URL') ?>signin/logout">Cerrar sesion</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>