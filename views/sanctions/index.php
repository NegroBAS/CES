<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-6 col-md-9 col-xl-10">
            <h4>Sanciones</h4>
        </div>
        <div class="col col-5 col-md col-xl ml-md-5 ml-xl-5 ml-4">
            <button class="btn btn-outline-primary ml-xl-4 ml-3" type="button" id="btn-create"><i class="fa fa-plus"></i>&nbsp;  Crear</button>
        </div>
    </div>
    <div class="row mt-3" id="data-sanctions">
        
    </div>
</div>


<!-- Modal CREATE -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crear Sancion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">              
              <form action="" method="post" id="form">
                  <div class="form-group">
                      <label for="name">Nombre</label>
                      <input type="text" name="name" id="name" class="form-control">
                      <div class="invalid-feedback"  id="nameMessage" >
                                             
                        </div>
                  </div>
              </form>
        <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" form="form" id="btnForm"  class="btn btn-primary"><i class="far fa-save"></i> Guardar</button>
        </div>                           
        </div>
    </div>
</div>


<?php require_once('views/layouts/footer.php') ?>