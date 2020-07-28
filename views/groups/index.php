<?php require_once('views/layouts/header.php') ?>
<?php require_once('views/partials/navbar.php') ?>


<div class="container my-5">
  <div class="row">
    <div class="col col-7 col-md-9">
      <h4>Grupos</h4>
    </div>
    <div class="col-2 col-md-3 text-right">
        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Opciones
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#" id="btn-create"><i class="fa fa-plus"></i> Crear</a>
          <a class="dropdown-item" href="#" id="btnUpdate"><i class="fas fa-sync-alt"></i> Actualizar</a>
        </div>
      
    </div>
  </div>

  <div class="row mt-3">
    <div class="col">
      <table class="table table-striped display" style="width:100%" id="group">
        <thead>
          <tr>
            <th>Ficha</th>
            <th>Programa</th>
            <th>Modalidad</th>
            <th>Aprendices</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody id="data-groups">
        </tbody>
      </table>
    </div>
  </div>

</div>




<!-- Modal CREATE -->
<div class="modal fade" id="modal-creat">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Crear Grupo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form">
          <div class="form-row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="code_tab">Ficha</label>
                <input type="number" name="code_tab" id="code_tab" class="form-control">
                <div class="invalid-feedback" id="codeMessage"></div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="code_tab">Modalidad</label>
                <select name="modality_id" id="modality_id" class="form-control"></select>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                            <div class="form-group">
                                <label for="group_id">Programa de formacion</label>
                                <input type="text" name="formation_program_name" id="formation_program_name" class="form-control" placeholder="Busca aqui...">
                                <input type="text" hidden name="formation_program_id" id="formation_program_id" value="">                                                        
                                <div id="content-program">
                                </div>
                            </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="quantity_learners">Cantidad aprendices</label>
                <input type="number" name="quantity_learners" id="quantity_learners" class="form-control">
                <div class="invalid-feedback" id="quantityMessage"></div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="active_learners">Aprendices activos</label>
                <input type="number" name="active_learners" id="active_learners" class="form-control" value="">
                <div class="invalid-feedback" id="activeMessage"></div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="code_tab">Inicio etapa lectiva</label>
                <input type="date" name="elective_start_date" id="elective_start_date" class="form-control">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="code_tab">Fin etapa lectiva</label>
                <input type="date" name="elective_end_date" id="elective_end_date" class="form-control">
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <div class="form-group">
                <label for="code_tab">Inicio practica</label>
                <input type="date" name="practice_start_date" id="practice_start_date" class="form-control">
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <label for="code_tab">Fin practica</label>
                <input type="date" name="practice_end_date" id="practice_end_date" class="form-control">
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
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog">
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
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Institucionales</a>
                        <a class="nav-item nav-link" id="nav-learners-tab" data-toggle="tab" href="#nav-learners" role="tab" aria-controls="nav-learners" aria-selected="false">Aprendices Asociados</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                        <!-- Tab 1 -->
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                      <div class="container  text-center">
                          <div class="row">
                              <div class="col">
                                  <div class="row mt-3">
                                      <div class="col">
                                          <strong>Nombre del Programa de Formación</strong>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col">
                                          <p class="text-muted" id="name_formation"></p>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col">
                                  <div class="row mt-1">
                                        <div class="col">
                                            <strong>Código del Grupo</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="code_tab"></p>
                                        </div>
                                    </div>
                              </div>
                              <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Tipo de programa Formación</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="formation_program_type_name"></p>
                                        </div>
                                    </div>
                              </div>
                              <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Modalidad</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="name_modality"></p>
                                        </div>
                                    </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col">
                                  <div class="row mt-1">
                                        <div class="col">
                                            <strong>Cantidad de Aprendices</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="quantity_learners"></p>
                                        </div>
                                    </div>
                              </div>
                              <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Aprendices Activos</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="active_learners"></p>
                                        </div>
                                    </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col">
                                  <div class="row mt-1">
                                        <div class="col">
                                            <strong>Inicio Etapa Lectiva</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="elective_start_date"></p>
                                        </div>
                                    </div>
                              </div>
                              <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Fin Etapa Lectiva</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="elective_end_date"></p>
                                        </div>
                                    </div>
                              </div>
                              <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Inicio Etapa Práctica</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="practice_start_date"></p>
                                        </div>
                                    </div>
                              </div>
                              <div class="col">
                                    <div class="row mt-1">
                                        <div class="col">
                                            <strong>Fin Etapa Práctica</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="practice_end_date"></p>
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
                                            <strong>Aprendices Activos</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <p class="text-muted" id="name_learners"></p>
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