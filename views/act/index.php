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
            <h4>Actos academicos a tratar</h4>
        </div>
    </div>
    <div class="row" id="content">
    </div>
</div>

<?php require('views/layouts/footer.php') ?>