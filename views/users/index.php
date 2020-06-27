<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-8 col-md-10">
            <h4>Usuarios</h4>
        </div>
        <div class="col-2 text-right">
            <button id="btn-create" class="btn btn-success btn-sm">Crear</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <table class="table table-bordered display nowrap" style="width:100%" id="users">
                <thead>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Opciones</th>
                </thead>
                <tbody id="data-users">
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Create -->
<div class="modal fade" tabindex="-1" role="dialog">
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
                <input type="text" name="name" id="name" class="form-control" autocomplete="off">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label for="rol_id">Rol</label>
                <select name="rol_id" id="rol_id" class="form-control">
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" form="form" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<?php require_once('views/layouts/footer.php') ?>