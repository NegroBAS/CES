<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<!-- <?php   print_r($this->pos);  ?> -->

<div class="container my-5">
    <div class="row">
        <div class="col  col-9 col-md-10">
            <h4>Parametros de Comite</h4>
        </div>
        <div class="col-2 text-md-right">
                <button class="btn btn-success btn-sm" type="button" id="btn-create" ><i class="fa fa-plus"></i> Crear</button>
        </div>
    </div>
    
    <div class="row mt-3">
                <div class="col">
                        <table class="table table-striped display nowrap" style="width:100%" id="tabla">
                                <thead>
                                        <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Contenido</th>
                                        <th scope="col">Nombre de la seccion de comite</th>
                                        <th scope="col">Opciones</th> 
                                        </tr>
                                </thead>
                                <tbody id="data-comitte_parameters">

                                 
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
        <h5 class="modal-title" id="modalLabel">Nuevo Parametro de Comite</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">

                        <form id="form">
                                <div class="form-row">
                                        <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                                <!-- //nombre// -->
                                                                <label class="font-weight-bold" for="name">Nombre</label>
                                                                <input type="text" class="form-control" id="name" name="name" placeholder="" value="">
                                                                <div class="invalid-feedback" id="nameMessage">
                                                                
                                                                </div>
                                                </div>
                                                
                                        </div>
                                        <div class="col-12 col-md-6">
                                                <div class="form-group">
                                                        <!-- //Id Sesion comite// -->
                                                        <label class="font-weight-bold" for="name">Nombre session comite</label>
                                                        <select  class="form-control" id="comitte_session_state_id" name="comitte_session_state_id" placeholder="" value=""></select>
                                                        <div class="invalid-feedback" >
                                                        
                                                        </div>

                                                </div>
                                        </div>
                                </div>

                                <div class="form-row">
                                        <div class="col">
                                                <div class="form-group">
                                                        <!-- //Contrenido// -->
                                                        <label class="font-weight-bold" for="content">Contenido</label>
                                                        <textarea  class="form-control" cols="30" rows="8" id="content" name="content" placeholder="" value="" ></textarea>
                                                        <div class="invalid-feedback" id="contentMessage">
                                                        
                                                        </div>

                                                </div>
                                        </div>
                                </div>
                        </form>

                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button  type="submit" form="form" id="btnForm"  class="btn btn-primary"><i class="far fa-save"></i> Guardar</button>
                </div>                     
        </div>

    </div>
  </div>
</div>

</div>


<?php require_once('views/layouts/footer.php') ?>