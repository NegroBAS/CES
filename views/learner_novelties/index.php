<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-6 col-md-9 col-xl-10">
            <h4>Novedades Aprendices</h4>
        </div>
        <div class="col col-5 col-md ml-4 col-xl ml-md-5 ml-xl-4">
                <button class="btn btn-outline-primary ml-3 ml-xl-5" type="button" id="btn-create"><i class="fa fa-plus"></i>&nbsp; Crear</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <table id="requestab" class="table table-bordered display nowrap" style="width:100%">
                                <thead>
                                        <tr>
                                        <th scope="col">Aprendiz</th>
                                        <th scope="col">Comite</th>
                                        <th scope="col">Novedad</th>
                                        <th scope="col">Justificacion</th>
                                        <th scope="col">Fecha Respuesta</th>
                                        <th scope="col">Opciones</th> 
                                        </tr>
                                </thead>
                                <tbody id="data-learner_novelties">

                                 
                                </tbody>
                        </table>
                </div>
        </div>
</div>


<!-- Modal CREATE -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crear Tipo de Solicitud</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                        <form action="" method="post" id="form">
                        <div class="form-row">
                                <div class="col-12 col-md-6 col-xl-6">
                                 <div class="form-group">
                                        <label for="learner_id">Aprendiz</label>
                                        <select  name="learner_id" id="learner_id" class="form-control"></select>
                                 </div>                              
                                </div>
                                <div class="col-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                                <label for="committee_id">Comite</label>
                                                <select  name="committee_id" id="committee_id" class="form-control"></select>
                                        </div>                                  
                                </div>
                        </div>

                        <div class="form-row">
                                <div class="col-12 col-md-6 col-xl-6">
                                 <div class="form-group">
                                        <label for="novelty_type_id">Novedad</label>
                                        <select  name="novelty_type_id" id="novelty_type_id" class="form-control"></select>
                                 </div>                              
                                </div>
                                <div class="col-12 col-md-6 col-xl-6">
                                        <div class="form-group">
                                                <label for="reply_date">Fecha respuesta</label>
                                                <input type="date"  name="reply_date" id="reply_date" class="form-control">
                                        </div>                                  
                                </div>
                        </div>
                        <div class="form-row">
                                <div class="col">                                     
                                        <div class="form-group">
                                                <label for="justification">Justificacion</label>
                                                <textarea cols="30" rows="2"  name="justification" id="justification" class="form-control"></textarea>
                                                <div class="invalid-feedback" id="justificationMessage">

                                                 </div>
                                        </div>      
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