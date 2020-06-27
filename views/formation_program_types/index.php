<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
  <div class="row">
    <div class="col col-7 col-md-10">
      <h4>Tipos de programas de formacion</h4>
    </div>
    <div class="col-2 text-md-right">
      <div class="dropdown">
        <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Opciones
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <a class="dropdown-item" href="#" id="btn-create"><i class="fa fa-plus"></i> Crear</a>
          <a class="dropdown-item" href="#" id="btnUpdate"><i class="fas fa-sync-alt"></i> Actualizar</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-3" id="data-formation_program_types">

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

          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control">
                <div class="invalid-feedback" id="nameMessage">
                </div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="name">Meses lectivos </label>
                <input type="number" name="elective_months" id="elective_months" class="form-control">
                <div class="invalid-feedback" id="electiveMessage">

                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="name">Meses practicos</label>
                <input type="number" name="practice_months" id="practice_months" class="form-control">
                <div class="invalid-feedback" id="practiceMessage">

                </div>

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