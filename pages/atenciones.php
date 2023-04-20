<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Registro de Atenciones</h3>
            </div>
            <div class="block-content">
                <div class="ml-3 mt-2">
                    <button type="button" class="btn btn-outline-secondary mr-5 mb-5" data-toggle="modal" data-target="#modalAtencion">
                        <i class="fa fa-plus mr-5"></i>Nuevo Registro
                    </button>
                </div>
                <div class="mt-4">
                    <table id="tbllistadoAtenciones" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="" style="width: 12%;">Op</th>
                                <th>Profesional</th>
                                <th class="">Area</th>
                                <th class="">Turno</th>
                                <th class="" style="width: 5%;">N. Sol</th>
                                <th class="">observaciones</th>
                                <th class="" style="width: 12%;">fecha</th>
                                <th class="">Paciente</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- From Left Modal -->
<div class="modal fade" id="modalAtencion" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fromleft" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="tituloModal">Nuevo Registro</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form method="post" id="formulario" name="formulario">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <h6>Datos del paciente</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-7">
                                        <div class="form-material">
                                            <input type="hidden" id="txtIdpaciente" name="txtIdpaciente">
                                            <input type="hidden" id="txtIdatencion" name="txtIdatencion">
                                            <input type="text" class="form-control" id="txtDni" name="txtDni">
                                            <label for="txtDni">DNI</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="form-material">
                                            <input type="text" class="form-control" id="txtNombres" name="txtNombres">
                                            <label for="txtNombres">Nombres</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="form-material">
                                            <input type="text" class="form-control" id="txtApellidos" name="txtApellidos">
                                            <label for="txtApellidos">Apellidos</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <h6>Datos de de la atención</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-material">
                                    <input type="text" class="js-datepicker form-control" id="txtFecAte" name="txtFecAte" data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                    <label for="txtFecAte">Fecha Atencion</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-material">
                                    <select class="form-control" id="txtTurno" name="txtTurno" style="width: 100%;">
                                        <option value="MAÑANA">MAÑANA</option>
                                        <option value="TARDE">TARDE</option>
                                        <option value="NOCHE">NOCHE</option>
                                    </select>
                                    <label for="txtTurno">Turno</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-material">
                                    <input type="number" class="form-control" id="txtNunSol" name="txtNunSol">
                                    <label for="txtNunSol">N. Solicitud</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-material">
                                    <select class="form-control" id="txtArea" name="txtArea" style="width: 100%;">
                                    </select>
                                    <label for="txtArea">Area</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-material">
                                    <select class="form-control" id="txtCantExa" name="txtCantExa" style="width: 100%;">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                    <label for="txtCantExa">Cant. Examenes</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-4">
                            <div class="col-md-6">
                                <div class="form-material">
                                    <select class="form-control" id="txtProfesional" name="txtProfesional" style="width: 100%;">
                                    </select>
                                    <label for="txtProfesional">Profesional</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-material">
                                    <textarea class="form-control" id="txtObservaciones" name="txtObservaciones" rows="3"></textarea>
                                    <label for="txtObservaciones">Observaciones</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal" id="btnCancelar">Cancelar</button>
                                <button type="submit" class="btn btn-alt-success">
                                    <i class="fa fa-check"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <p>Todos los campos deben ser ingresados</p>
            </div>
        </div>
    </div>
</div>
<!-- END From Left Modal -->

<script src="pages/scripts/atencion.js"></script>