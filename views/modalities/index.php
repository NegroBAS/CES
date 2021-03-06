<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>


<div class="container my-5">
  <div class="row">
    <div class="col col-7 col-md-9">
      <h4>Modalidades</h4>
    </div>
    <div class="col-2 col-md-3 text-right">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Opciones
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="#" id="btn-create"><i class="fa fa-plus"></i> Crear</a>
          <a class="dropdown-item" href="#" id="btnUpdate"><i class="fas fa-sync-alt"></i> Actualizar</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row my-3" id="data-modalities">

  </div>
</div>


<!-- Modal CREATE -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crear Modalidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form">
          <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" class="form-control">
            <div class="invalid-feedback" id="nameMessage">

            </div>
          </div>
        </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" form="form" id="btnForm" class="btn btn-primary"><i class="far fa-save"></i> Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('views/layouts/footer.php') ?>