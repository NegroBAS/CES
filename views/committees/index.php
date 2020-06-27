<?php require('views/layouts/header.php') ?>
<?php require('views/partials/navbar.php') ?>
<div class="container my-5">
    <div class="row">
        <div class="col col-9 col-md-10">
            <h4>Comités</h4>
        </div>
        <div class="col-2 text-right">
            <button class="btn btn-sm btn-success" id="btn-create"><i class="fa fa-plus"></i> Crear</button>
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
                                <input type="checkbox" class="custom-control-input" id="switch1" name="qourum">
                                <label class="custom-control-label" for="switch1">Existe Qourum</label>
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
                <div class="row">
                    <div class="col">
                        <h6>¿Que caso se va tratar?</h6>
                        <div class="mt-2 ml-2" id="committee_session_types"></div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col" id="content">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="form">Guardar</button>
            </div>
        </div>
    </div>
</div>
<?php require('views/layouts/footer.php') ?>