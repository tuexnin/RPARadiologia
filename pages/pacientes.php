<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Pacientes</h3>
            </div>
            <div class="block-content">
                <div class="mt-4">
                    <table id="tbllistadoPacientes" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="" style="width: 15%;">Op</th>
                                <th>Paciente</th>
                                <th class="" style="width: 15%;">DNI</th>
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
<div class="modal fade" id="modalPaciente" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
    <div class="modal-dialog modal-dialog-fromleft" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="tituloModal">Editar Paciente</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <form method="post" id="formulario" name="formulario">
                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <div class="form-material">
                                    <input type="hidden" id="txtIdpaciente" name="txtIdpaciente">
                                    <input type="number" class="form-control" id="txtDni" name="txtDni">
                                    <label for="txtDni">DNI</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="txtNombres" name="txtNombres">
                                    <label for="txtNombres">Nombres</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="txtApellidos" name="txtApellidos">
                                    <label for="txtApellidos">Apellidos</label>
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

<!-- From Left Modal -->
<div class="modal fade" id="modalRegAt" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-fromleft" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="tituloModal2"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="mt-4">
                        <table id="tbllistadoRegistros" class="table table-bordered table-striped table-vcenter js-dataTable-full" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="" style="width: 15%;">Fecha</th>
                                    <th>Turno</th>
                                    <th class="" style="width: 10%;"># S</th>
                                    <th class="" >Profesional</th>
                                    <th class="" >Area</th>
                                    <th class="" >C. Ex</th>
                                    <th class="" >Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p>Muestra todos los registros de atenciones de un paciente</p>
            </div>
        </div>
    </div>
</div>
<!-- END From Left Modal -->

<script src="pages/scripts/pacientes.js"></script>