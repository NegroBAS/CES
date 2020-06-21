<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col">
            <h4>Aprendices</h4>
        </div>
        <div class="col-2 text-right">
            <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="#" class="dropdown-item" id="btn-create">Agregar</a>
                <a href="#" class="dropdown-item">Subir Excel</a>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col">
            <table id="learners" class="table table-bordered">
                <thead>
                    <th>Nombre</th>
                    <th>Tipo de documento</th>
                    <th>Documento</th>
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
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crear Aprendiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form enctype="multipart/form-data" method="post" id="form" >
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
                        <div class="col-6">
                            <div class="form-group">
                                <label for="document_type_id">Tipo Documento</label>
                                <select name="document_type_id" id="document_type_id" class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="document">Documento</label>
                                <input type="number" name="document" id="document" class="form-control">
                                <div class="invalid-feedback" id="documentMessage">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="phone">Telefono</label>
                                <input type="number" name="phone" id="phone" class="form-control">
                                <div class="invalid-feedback" id="phoneMessage">

                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="@example">
                                <div class="invalid-feedback" id="emailMessage">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="group_id">Grupo</label>
                                <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Busca aqui...">
                                <input type="text" hidden name="group_id" id="group_id" value="">                                                        
                                <div id="content-group">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="birthdate">Fecha Nacimiento</label>
                                <input type="date" name="birthdate" id="birthdate" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="photo">Fotografia</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Subir</span>
                                        </div>

                                        <div class="custom-file">                        
                                            <input type="file" class="custom-file-input" id="photo" name="photo"  lang="es" value="" >
                                            <label class="custom-file-label" for="photo"  data-browse="Buscar">Seleccionar Archivo</label>
                                        </div>
                                        <!-- //link photo hidden -->
                                        <input type="text" hidden name="photo_2" id="photo_2" value=""> 

                                    </div>
                                    
                                </div>
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