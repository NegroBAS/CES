<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-7 col-md-9">
            <h4>Aprendices</h4>
        </div>
        <div class="col-2 col-md-3 text-right">
            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item" id="btn-create">Agregar</a>
                <a href="#" class="dropdown-item" id="btn-update">Subir Excel</a>
                
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <table id="learners" class="table table-bordered display" style="width:100%">
                <thead>
                    <th>Documento</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Correo electronico</th>
                    <th>Opciones</th>
                </thead>
                <tbody id="data-learners">
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Modal CREATE -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crear Aprendiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?php echo constant('URL') ?>learners/store" enctype="multipart/form-data" method="post" id="form" autocomplete="off">
                    <div class="form-row">
                        <div class="col">
                                <div class="form-group">
                                <label for="username">Nombre</label>                              
                                <input type="text" name="username" id="username" class="form-control">
                                <div class="invalid-feedback" id="nameMessage">

                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="document_type">Tipo Documento</label>
                                <select name="document_type" id="document_type" class="form-control">
                                    <option value="">Seleccione uno</option>
                                    <option value="CC">Cedula de ciudadania</option>
                                    <option value="TI">Tarjeta de identidad</option>
                                    <option value="CE">Cedula extranjera</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="document">Documento</label>
                                <input type="number" name="document" id="document" class="form-control">
                                <div class="invalid-feedback" id="documentMessage">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="phone">Telefono</label>
                                <input type="number" name="phone"  minlength="7" maxlength="12" id="phone" class="form-control">
                                <div class="invalid-feedback" id="phoneMessage">

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="@example">
                                <div class="invalid-feedback" id="emailMessage">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="group_id">Grupo</label>
                                <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Busca aqui...">
                                <input type="text" hidden name="group_id" id="group_id" value="">                                                        
                                <div id="content-group">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="birthdate">Fecha Nacimiento</label>
                                <input type="date" name="birthdate" id="birthdate" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                        <div class="form-row pb-2">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="photo">Fotografia</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Subir</span>
                                        </div>

                                        <div class="custom-file">                        
                                            <input type="file" class="custom-file-input" id="photo" name="photo"  lang="es" value="" >
                                            <label class="custom-file-label" id="archivo_label2" for="photo"  data-browse="Buscar">Seleccionar archivo</label>
                                        </div>        
                                        <!-- //link photo hidden -->
                                        <input type="text" hidden name="photo_2" id="photo_2" value="">

                                    </div>                               
                                </div>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-2" id="add-photo">
                                <img class=" aling-self-center shadow p-1 bg-white rounded" src="public/uploads/silueta.png" id="img-view"  width="100px" height="100px">                                 
                            </div>
                            <div class="col-1"></div>
                        </div>

                        <!-- separar imagen de borde -->
                        <p></p>
 
                </form>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit"  form="form" id="btnForm"  class="btn btn-primary"><i class="far fa-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Modal CSV -->
<div class="modal fade" id="filecsv" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="form_csv" enctype="multipart/form-data" method="post" autocomplete="off">   
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="group_id_csv">Grupo</label>
                                <input type="text" name="group_name_csv" id="group_name_csv" class="form-control" placeholder="Busca aqui...">
                                <input type="text" hidden name="group_id_csv" id="group_id_csv">                                                        
                                <div id="content_group_csv">
                                </div>
                            </div>
                        </div>
                       
                    </div>           
                   <div class="form-row">
                           <div class="col">
                               <div class="form-group">
                                   <label for="archivo">Archivo csv</label>
                                   <div class="input-group mb-3">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text">Subir</span>
                                       </div>

                                       <div class="custom-file">                        
                                           <input type="file" class="custom-file-input" id="archivo" name="archivo"  lang="es" value="" >
                                           <label class="custom-file-label" id="archivo_label" for="archivo"  data-browse="Buscar">Seleccionar Archivo</label>
                                       </div>

                                   </div>                                  
                               </div>
                           </div>
                       
                       </div>               
            </form>

               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                   <button type="submit" form="form" id="btnFormCsv"  class="btn btn-primary"><i class="far fa-save"></i> Guardar</button>
               </div>
      </div>
 
    </div>
  </div>
</div>

<!-- Modal Detail -->
<div class="modal fade mt-4 " id="modal-detail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos Personales</a>
                        <a class="nav-item nav-link" id="nav-learners-tab" data-toggle="tab" href="#nav-learners" role="tab" aria-controls="nav-learners" aria-selected="false">Grupo Asociado</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                        <!-- Tab 1 -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="container  text-center">
                            <div class="row">
                                <div class="col">
                                    <p id="photo"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-5">
                                    <div class="row mt-3">
                                        <div class="col">
                                            <strong>Documento</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5">
                                            <p class="text-muted text-right" id="document_type"></p>
                                        </div>
                                        <div class="col">
                                            <p class="text-muted text-left" id="document"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row mt-3">
                                        <div class="col">
                                            <strong>Nombre del Aprendiz</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="username"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Fecha de Nacimiento</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="birthdate"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Teléfono</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="phone"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Correo de Comunicación</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="email"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                    </div>

                    <!-- Tab 2 -->
                    <div class="tab-pane fade" id="nav-learners" role="tabpanel" aria-labelledby="nav-learners-tab">
                        <div class="container">
                            
                            <div class="row">
                                <div class="col">
                                    <div class="row mt-3 text-center">
                                        <div class="col">
                                            <strong>Grupo Asociado</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="group"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
            </div>
        </div>
    </div>



<?php require_once('views/layouts/footer.php') ?>