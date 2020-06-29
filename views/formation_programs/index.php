<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">

  <div class="row">
    <div class="col col-8 col-md-10">
      <h4>Programas de Formacion</h4>
    </div>
    <div class="col-2 text-right">
      <div class="dropdown">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Opciones
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="#" id="btn-create"><i class="fa fa-plus"></i> Crear</a>
          <a class="dropdown-item" href="#" id="btnUpdate"><i class="fas fa-sync-alt"></i> Actualizar</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col">
      <table class="table table-striped display" style="width:100%" id="tabla">
        <thead>
          <tr>
            <th scope="col">Codigo</th>
            <th scope="col">Nombre</th>
            <th scope="col">Tipo de programa</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id="data-formation_programs">

        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Editar Programa de Formacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form action="" method="post" id="form">
          <div class="form-row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="code">Codigo</label>
                <input type="text" name="code" id="code" class="form-control">
                <div class="invalid-feedback" id="codeMessage"></div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="formation_program_type_id">Tipo de programa</label>
                <select name="formation_program_type_id" id="formation_program_type_id" class="form-control"></select>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" class="form-control" name="name" id="name">
                <div class="invalid-feedback" id="nameMessage"></div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" form="form" id="btnForm" class="btn btn-primary"><i class="far fa-save"></i> Guardar</button>
      </div>

    </div>
  </div>
</div>


<?php require_once('views/layouts/footer.php') ?>