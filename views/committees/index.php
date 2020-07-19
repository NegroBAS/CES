<?php require('views/layouts/header.php') ?>
<?php require('views/partials/navbar.php') ?>
<div class="container my-5">
    <div class="row">
        <div class="col col-6 col-md-9 col-xl-9">
            <h3>Comités</h3>
        </div>
        <div class="col col-5 col-md ml-4 text-right">
            <button class="btn btn-outline-primary" id="btn-create"><i class="fa fa-plus"></i> Crear</button>
        </div>
    </div>
    <div class="row mt-3" id="data-committees">
    </div>
</div>
<!-- Modal  -->
<div class="modal fade" tabindex="-1" role="dialog" id="modal-create">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="date">Fecha:</label>
                                <input type="date" name="date" id="date" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Hora:</label>
                                        <div class="form-row">
                                            <div class="col">
                                                <input type="time" name="start_hour" id="start_hour" class="form-control">
                                            </div>
                                            <div class="col">
                                                <input type="time" name="end_hour" id="end_hour" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="record_number">Numero de acta</label>
                                <input type="text" name="record_number" id="record_number" class="form-control">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="place">Lugar</label>
                                <input type="text" name="place" id="place" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="formation_center">Centro de formacion</label>
                                <input type="text" name="formation_center" id="formation_center" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="formation_center">Asistentes</label>
                                <div id="assistants"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="qourum" name="qourum">
                                <label class="custom-control-label" for="qourum">Existe Qourum</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <h6 style="font-style: italic;" id="subdirector-name"></h6>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btnCommitteeCreate" class="btn btn-primary" form="form"><i class="far fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Case -->
<div class="modal fade" id="modal-case" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="committee_id" id="committee_id">
                <div class="row">
                    <div class="col">
                        <h6>¿Que caso se va tratar?</h6>
                        <div class="mt-2 ml-2" id="committee_session_types"></div>
                    </div>
                </div>
                <hr>
                <div class="row mt-3">
                    <div class="col" id="content">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnAddSession">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Cases -->
<div class="modal fade" id="modal-cases" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col" id="stimulus">
                    </div>
                    <div class="col" id="novelties">
                    </div>
                    <div class="col" id="academics">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Stimulus Detail -->
<div class="modal fade" id="modal-stimulus-detail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h6>Aprendiz</h6>
                        <p id="learner"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6>Estimulo</h6>
                        <p id="stimulus"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6>Justificacion</h6>
                        <p id="stimulus_justification"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Stimulus Detail -->
<div class="modal fade" id="modal-novelty-detail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <h6>Tipo de novedad</h6>
                        <p id="novelty_type"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6>Aprendiz</h6>
                        <p id="learner"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <h6>Jusitificacion</h6>
                        <p id="justification"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                <div class="row">
                    <div class="col border-right">
                        <div class="row">
                            <div class="col">
                                <h6>Fecha</h6>
                            </div>
                            <div class="col">
                                <h6>Hora inicio</h6>
                            </div>
                            <div class="col">
                                <h6>Hora fin</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="text-muted" id="date"></p>
                            </div>
                            <div class="col">
                                <p class="text-muted" id="start_hour"></p>
                            </div>
                            <div class="col">
                                <p class="text-muted" id="end_hour"></p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <h6>Numero de acta</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="text-muted" id="record_number"></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <h6>Lugar</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="text-muted" id="place"></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <h6>Centro de formacion</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="text-muted" id="formation_center"></p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <h6>¿Existe Quorum?</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="text-muted" id="qourum"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <h6>Asistentes</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-muted" id="assistants">
                                
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
<?php require('views/layouts/footer.php') ?>