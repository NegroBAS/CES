<?php require('views/layouts/header.php') ?>
<?php require('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-7 col-md-10">
            <h4>Cargos</h4>
        </div>
        <div class="col-2 text-md-right">
            <div class="dropdown">
                <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Opciones
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" id="btn-create">Agregar</a>
                    <a class="dropdown-item" href="#" id="update">Actualizar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3" id="data-positions">
        
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
          <div class="form-row">
            <div class="col">
                    <div class="form-group">
                    <label for="name" class="text-muted">nombre</label>
                      <input type="text" name="name" id="name" class="form-control">
                  <div class="invalid-feedback" id="nameMessage">

                  </div>

                  </div>
            </div>
          
          </div>
          <div class="form-row">
                  <div class="col">
                  <div class="form-group">
                  <label for="type" class="text-muted">tipo</label>
                  <input type="text" name="type" id="type" class="form-control">
                  <div class="invalid-feedback" id="typeMessage">

                  </div>
                </div>
              
                </div>
          </div>
          
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="submit" form="form" class="btn btn-primary" id="btnForm">Guardar</button>
      </div>
    </div>
  </div>
</div>

<?php require('views/layouts/footer.php') ?>

