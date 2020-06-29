<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-8 col-md-10">
            <h4>Tipos de novedades</h4>
        </div>
        <div class="col-2 text-right">
            <button class="btn btn-outline-primary" id="btn-create">Agregar</button>
        </div>
    </div>
    <div class="row mt-3" id="data-novelty-types">
        
    </div>
</div>
<!-- Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-create">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="form">
              <div class="form-group">
                  <label for="name">Nombre</label>
                  <input type="text" name="name" id="name" class="form-control">
                  <div class="invalid-feedback" id="nameMessage">

                </div>
              </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" form="form" id="btnForm" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<?php require_once('views/layouts/footer.php') ?>