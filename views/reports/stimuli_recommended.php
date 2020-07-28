<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-8 col-md-10">
            <h4>Aprendices recomendados para estimulos</h4>
        </div>
    </div>
    <div class="row mt-3" id="data">
        <div class="col">
            <table class="table">
                <thead>
                    <tr>
                        <th>Aprendiz</th>
                        <th>Grupo</th>
                        <th>Programa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(count($this->learners['learners'])>0){
                            foreach ($this->learners['learners'] as $learner) { ?>
                                <tr>
                                    <td><?php echo $learner->username ?></td>
                                    <td><?php echo $learner->group_code_tab ?></td>
                                    <td><?php echo $learner->program_name ?></td>
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