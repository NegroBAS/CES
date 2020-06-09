<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>


<div class="container my-5">
  <div class="row">
        <div class="col">
            <h3>Cargos</h3>
        </div>
        <div class="col-2 text-right">
        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#" id="btnCreate" data-target="#modal" data-toggle="modal">Agregar</a>
                <a class="dropdown-item" href="#" id="btnUpdate">Actualizar informacion</a>
            </div>
        </div>
    </div>
  <div class="row my-3" id="data-positions">

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
        <form id="form">
          <div class="form-group">
            <label for="name" class="text-muted">Nombre</label>
            <input type="text" name="name" id="name" class="form-control">
          </div>
          <div class="form-group">
            <label for="type" class="text-muted">Tipo</label>
            <input type="text" name="type" id="type" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnForm" data-dismiss="modal" class="btn btn-success"><i class="far fa-save"></i> Guardar</button>
      </div>
    </div>
  </div>
</div>

<?php require_once('views/layouts/footer.php') ?>