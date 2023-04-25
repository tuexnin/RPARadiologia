<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Profesionales</h3>
            </div>
            <div class="block-content">
                <div class="ml-3 mt-2">
                    <button type="button" class="btn btn-outline-secondary mr-5 mb-5" data-toggle="modal" data-target="#modalProfesional">
                        <i class="fa fa-plus mr-5"></i>Agregar Profesional
                    </button>
                </div>
                <div class="mt-4">
                    <table id="tbllistadoProfesionales" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="" style="width: 10%;">Op</th>
                                <th>Profesional</th>
                                <th class="" style="width: 15%;">DNI</th>
                                <th class="d-none d-sm-table-cell">Profesion</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">CMP</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Estado</th>
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
<div class="modal fade" id="modalProfesional" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
    <div class="modal-dialog modal-dialog-fromleft" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="tituloModal">Agregar Profesional</h3>
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
                                    <input type="hidden" id="txtIdprofesional" name="txtIdprofesional">
                                    <input type="text" class="form-control" id="txtDni" name="txtDni" placeholder="Ingrese su DNI">
                                    <label for="txtDni">DNI</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="txtNombres" name="txtNombres" placeholder="Ingrese los nombres">
                                    <label for="txtNombres">Nombres</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="txtApellidos" name="txtApellidos" placeholder="Ingrese los apellidos">
                                    <label for="txtApellidos">Apellidos</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-md-9">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="txtProfesion" name="txtProfesion" placeholder="Ingrese la profesion">
                                    <label for="txtProfesion">Profesion</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <div class="col-9">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="txtCmp" name="txtCmp" placeholder="Ingrese el CMP">
                                    <label for="txtCmp">CMP</label>
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
                                    <th class="" >Pasiente</th>
                                    <th class="" style="width: 13%;">Fecha A.</th>
                                    <th>Turno</th>
                                    <th class="" style="width: 10%;"># S</th>
                                    <th class="" >Area</th>
                                    <th class="" >C. Ex</th>
                                    <th class="" >Observaciones</th>
                                    <th class="" style="width: 13%;">Fecha R.</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <p>Muestra todos los registros de atenciones echas por un Profesional</p>
            </div>
        </div>
    </div>
</div>
<!-- END From Left Modal -->

<script src="pages/scripts/profesionales.js"></script>