<div class="row">
    <div class="col-md-12">
        <div class="block block-themed">
            <div class="block-header bg-primary-dark">
                <h3 class="block-title">Areas</h3>
            </div>
            <div class="block-content">
                <div class="ml-3 mt-2">
                    <button type="button" class="btn btn-outline-secondary mr-5 mb-5" data-toggle="modal" data-target="#modalArea">
                        <i class="fa fa-plus mr-5"></i>Agregar Area
                    </button>
                </div>
                <div class="col-md-7 mt-4">
                    <table id="tbllistadoAreas" class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="" style="width: 10%;">OPCIONES</th>
                                <th class="text-center">Area</th>
                                <th class="text-center" style="width: 15%;">Estado</th>
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
<div class="modal fade" id="modalArea" tabindex="-1" role="dialog" aria-labelledby="modal-fromleft" aria-hidden="true">
    <div class="modal-dialog modal-dialog-fromleft" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="tituloModal">Agregar Area</h3>
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
                                    <input type="hidden" id="txtIdarea" name="txtIdarea">
                                    <input type="text" class="form-control" id="txtNombre" name="txtNombre" placeholder="Ingrese el nombre del area" require>
                                    <label for="txtNombre">Nombre</label>
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

<script src="pages/scripts/areas.js"></script>