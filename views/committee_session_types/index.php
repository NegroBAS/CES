<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>


<div class="container my-5">
    <div class="row">
        <div class="col col-6 col-md-9 col-xl-10">
            <h4>Tipos de casos</h4>
        </div>
        <div class="col col-5 col-md ml-4 col-xl ml-md-5 ml-xl-5">
            <button class="btn btn-outline-primary ml-xl-2 " type="button" id="btn-create"><i class="fas fa-plus"></i> Agregar</button>
        </div>
    </div>
    <div class="row mt-3" id="data-committee_types">
        
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" name="name" id="name">
                        <div class="invalid-feedback" id="nameMessage">

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="form" id="btnForm"><i class="far fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<?php require_once('views/layouts/footer.php') ?>