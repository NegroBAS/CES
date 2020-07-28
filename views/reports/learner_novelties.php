<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-8 col-md-10">
            <h4>Novedades registradas este año <?php echo date('Y') ?></h4>
            <p>Numero de registros: <?php echo count($this->learner_novelties['learner_novelties'])?></p>
        </div>
    </div>
    <div class="row mt-3" id="data">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Aprendiz</th>
                        <th>Tipo de novedad</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(count($this->learner_novelties['learner_novelties'])>0){
                            foreach ($this->learner_novelties['learner_novelties'] as $learner_novelty) { ?>
                                <tr>
                                    <td><?php echo $learner_novelty->learner['username'] ?></td>
                                    <td><?php echo $learner_novelty->novelty_type['name'] ?></td>
                                    <td><?php echo $learner_novelty->created_at ?></td>
                                </tr>
                            <?php } ?>       
                        <? } else { ?>
                            <tr>
                                <td>No hay datos que mostrar</td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once('views/layouts/footer.php') ?>