<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
<div class="row">
        <div class="col">
            <h3>Tipos de Contratos</h3>
        </div>
        <div class="col-2 text-right">
        <button class="btn btn-success btn-sm "data-toggle="modal" data-target="#modal" id="btnCreate"><i class="fa fa-plus"></i>
             Crear
            </button>
        </div>
    </div>
  <div class="row my-3" id="data-contract_types">
  </div>
</div>

</div>


<!-- Modal CREATE -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crear Tipo de Contrato</h5>
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
          <button type="button" id="btnForm" data-dismiss="modal" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <?php require_once('views/layouts/footer.php') ?>