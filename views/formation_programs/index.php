<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">

    <div class="row">
        <div class="col">
            <h4>Programas de Formacion</h4>
        </div>
        <div class="col-2 text-right">
            <div class="dropdown">
            <button class="btn btn-success btn-sm text-white mb-3" data-toggle="modal" data-target="#modal" id="btnCreate"><i class="fa fa-plus"></i> Crear</button>
            </div>
        </div>
    </div>
    <div class="row">
                <div class="col">
                        <table class="table table-striped text-center" id="tabla">
                                <thead>
                                        <tr>
                                        <th scope="col">Codigo</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Nombre Tipo de Programa</th>
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
                            <div class="form-group">
                                 <div class="row">
                                         <div class="col">
                                         <label for="code">Codigo</label>
                                        <input type="text" name="code" id="code" class="form-control">
                                        <div class="invalid-feedback"  id="codeMessage" >
                                                    
                                        </div>
                                         </div>
                                         <div class="col">
                                         <label for="name">Nombre</label>
                                        <input type="text" name="name" id="name" class="form-control">
                                        <div class="invalid-feedback"  id="nameMessage" >
                                                    
                                        </div>
                                         </div>
                                          
                                 </div>
                            </div>
                            <div class="form-group">
                                <label for="formation_program_type_id">Nombre Tipo de Programa</label>
                                <select  name="formation_program_type_id" id="formation_program_type_id" class="form-control"></select>
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