<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>

<div class="container my-5">
    <div class="row">
        <div class="col col-7 col-md-10">
            <h4>Responsables de medidas formativas</h4>
        </div>
        <div class="col-2 ml-2 ml-md-0 text-right">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Opciones
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" id="btn-create">Agregar</a>
                    <a class="dropdown-item" href="#" id="update">Actualizar</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col col-10 col-md-12 col-lg-12">
            <table class="table table-bordered display nowrap" style="width:100%" id="formative-measure-responsibles">
                <thead>
                    <th>Nombre</th>
                    <th>Correo Misena</th>
                    <th>Documento</th>
                    <th>Telefono</th>
                    <th>Opciones</th>
                </thead>
                <tbody id="data-formative-measure-responsible">

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

                <form action="" method="post" id="form">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Personal</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Institucional</a>
                    </div>
                </nav>


                <div class="tab-content" id="nav-tabContent">
                        <!-- //parte1// -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
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
                                <label for="document_type_id">Tipo Documento</label>
                                <select name="document_type_id" id="document_type_id" class="form-control"></select>
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

                    <!-- //fecha y genero// -->
                    <div class="form-row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                            <label for="birthdate">Fecha Nacimiento</label>
                                            <input type="date" name="birthdate" id="birthdate" class="form-control">
                                        </div>
                                </div>                                    
                                <div class="col-12 col-md-6">
                                            <div class="form-group">
                                                    <label for="gender">Genero</label>
                                                    <select name="gender" id="gender" class="form-control">
                                                        <option value="M">Masculino</option>
                                                        <option value="F">Femenino</option>
                                                        <option value="NN">No definido</option>
                                                    </select>
                                            </div>
                                    </div>  
                        
                    </div>

                    <!-- //telefonos// -->
                    <div class="form-row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="phone">Celular</label>
                                <input type="number" name="phone" id="phone" class="form-control">
                                <div class="invalid-feedback" id="phoneMessage">

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="phone_ip">Telefono fijo</label>
                                <input type="number" name="phone_ip" id="phone_ip" class="form-control">
                                <div class="invalid-feedback" id="phone_ipMessage">

                                </div>
                            </div>
                        </div>
                    </div>

                    </div>

                    <!-- //parte2// -->
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                         <!-- //correos  // -->
                            <div class="form-row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="misena_email">Correo misena</label>
                                        <input type="email" name="misena_email" id="misena_email" class="form-control" placeholder="@example">
                                        <div class="invalid-feedback" id="misena_emailMessage"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="institutional_email">Correo institucional</label>
                                            <input type="email" name="institutional_email" id="institutional_email" class="form-control" placeholder="@example">
                                            <div class="invalid-feedback" id="institutional_emailMessage"></div>
                                        </div>
                                    </div>
                                                              
                                
                            </div>
                                
                            

                            <!-- //tipo contrato y cargo// -->
                            <div class="form-row">
                                <div class="col-6 col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="contract_type_id">Tipo de contrato</label>
                                        <select name="contract_type_id" id="contract_type_id" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="col-6 col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                        <label for="state">Estado</label>
                                        <select name="state" id="state" class="form-control">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- //tipo y cargo// -->
                            <div class="form-row">                               
                                <div class="col-6 col-12 col-md-6 col-lg-6 col-lx-8">
                                <div class="form-group">
                                        <label for="position_id">Cargo</label>
                                        <select name="position_id" id="position_id" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="col-6 col-12 col-md-6 col-lg-6 col-lx-4">
                                    <div class="form-group">
                                        <label for="type">Tipo</label>
                                        <input type="text" name="type" id="type" class="form-control"></input>
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
                                                <input type="file" class="custom-file-input" id="photo"  lang="es"  >
                                                <label class="custom-file-label" for="photo"  data-browse="Buscar">Seleccionar Archivo</label>
                                            </div>
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
    </div>




<?php require_once('views/layouts/footer.php') ?>