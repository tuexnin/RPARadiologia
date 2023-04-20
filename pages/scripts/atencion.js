var tabla;

function init() {
    listar();

    validarDni();

    $("#txtDni").on("input", function () {
        var valor = $(this).val();
        var regex = /^[0-9]{0,8}$/;
        if (!regex.test(valor)) {
            valor = valor.replace(/[^0-9]/g, "").substring(0, 8);
            $(this).val(valor);
        }
    });

    validarEntradaTexto("#txtNombres", 150);
    validarEntradaTexto("#txtApellidos", 150);

    $("#txtNombres").prop('readonly', true);
    $("#txtApellidos").prop('readonly', true);

    $("#txtTurno").select2({
        dropdownParent: $("#modalAtencion")
    });

    $("#txtArea").select2({
        dropdownParent: $("#modalAtencion")
    });

    $("#txtCantExa").select2({
        dropdownParent: $("#modalAtencion")
    });

    $("#txtProfesional").select2({
        dropdownParent: $("#modalAtencion")
    });

    selectProfesional();
    selectArea();

    $("#btnCancelar").click(function () {
        limpiar();
    });

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
}

function validarEntradaTexto(campo, cant){
    $(campo).on("input", function () {
        var valor = $(this).val().toUpperCase();
        $(this).val(valor);
    }).on("keydown keyup", function (e) {
        var valor = $(this).val().toUpperCase();
        $(this).val(valor);
        if (e.type === "keydown") {
            if (e.key.match(/^[a-z]$/i) && $(this).val().length >= cant && e.keyCode !== 8 && e.keyCode !== 32) {
                e.preventDefault();
            } else if (!e.key.match(/^[a-z]$/i) && e.keyCode !== 8 && e.keyCode !== 32) {
                e.preventDefault();
            }
        } else if (e.type === "keyup") {
            if (!$(this).val().match(/^[A-Z ]{0,cant}$/)) {
                var valorActual = $(this).val().toUpperCase();
                var valorNuevo = valorActual.replace(/[^A-Z ]/g, '').substring(0, cant);
                $(this).val(valorNuevo);
            }
        }
    });
}


function validarDni() {
    $("#txtDni").on("keyup", function (e) {
        txtDni = $("#txtDni").val();
        if (txtDni.length == 8) {
            $.post(
                "controllers/pacientes.controller.php?op=validarDni",
                { txtDni: txtDni },
                function (data) {
                    if (data == 1) {
                        $("#txtIdpaciente").val("");
                        $("#txtNombres").prop('readonly', false);
                        $("#txtApellidos").prop('readonly', false);
                    } else {
                        if (Array.isArray(JSON.parse(data))) {
                            datos = JSON.parse(data);
                            $("#txtIdpaciente").val(datos[0][0]);
                            $("#txtNombres").val(datos[0][2]);
                            $("#txtApellidos").val(datos[0][3]);
                        }
                    }
                }
            );
        } else if (txtDni.length < 8) {
            $("#txtIdpaciente").val("");
            $("#txtNombres").prop('readonly', true);
            $("#txtApellidos").prop('readonly', true);
            $("#txtNombres").val("");
            $("#txtApellidos").val("");
        }
    });

}

function selectProfesional() {
    $.post(
        "controllers/profesionales.controller.php?op=selectProfesional",
        function (data) {
            $("#txtProfesional").html(data);
        }
    );
}

function selectArea() {
    $.post(
        "controllers/areas.controller.php?op=selectArea",
        function (data) {
            $("#txtArea").html(data);
        }
    );
}


//Función Listar
function listar() {
    tabla = $("#tbllistadoAtenciones")
        .dataTable({
            dom: 'Bfrtip',
            buttons: [
                'excel', 'pdf'
            ],
            aProcessing: true, //Activamos el procesamiento del datatables
            aServerSide: true, //Paginación y filtrado realizados por el servidor
            language: {
                lengthMenu: "Mostrar _MENU_ Registros",
                zeroRecords: "Ningún registro encontrado",
                info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
                infoEmpty: "Ningún registro encontrado",
                infoFiltered: "(filtrados desde _MAX_ registros totales)",
                search: "Buscar:",
                loadingRecords: "Cargando...",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior",
                },
            },
            columnDefs: [
                { className: "centered", targets: [0] },
                { orderable: false, targets: [0] },
                { searchable: false, targets: [0] },
                //{ width: "30%", targets: [0] }
            ],
            responsive: true,
            ajax: {
                url: "controllers/atencion.controller.php?op=listar",
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                },
            },
            bDestroy: true,
            iDisplayLength: 5, //Paginación
            order: [[0, "desc"]], //Ordenar (columna,orden)
        })
        .DataTable();
}

function mostrar(idatencion) {
    $("#tituloModal").text("Editar Registro");
    $.post(
        "controllers/atencion.controller.php?op=mostrar",
        { txtIdatencion: idatencion },
        function (data) {
            data = JSON.parse(data);

            $("#modalAtencion").modal("show");

            $("#txtIdatencion").val(data[0]["idatencion"]);
            $("#txtFecAte").val(data[0]["fecha_atencion"]);
            $("#txtTurno").val(data[0]["turno"]).trigger('change');
            $("#txtNunSol").val(data[0]["n_solicitud"]);
            $("#txtArea").val(data[0]["area_id"]).trigger('change');
            $("#txtCantExa").val(data[0]["cantidad_ex"]).trigger('change');
            $("#txtProfesional").val(data[0]["profecional_id"]).trigger('change');
            $("#txtObservaciones").val(data[0]["observaciones"]);
            $.post(
                "controllers/pacientes.controller.php?op=mostrar",
                { txtIdpaciente: data[0]["paciente_id"] },
                function (data) {
                    data = JSON.parse(data);
                    $("#txtDni").prop('readOnly', true);
                    $("#txtIdpaciente").val(data[0]["idpaciente"]);
                    $("#txtDni").val(data[0]["dni"]);
                    $("#txtNombres").val(data[0]["nombres"]);
                    $("#txtApellidos").val(data[0]["apellidos"]);
                }
            );
        }
    );
}

function limpiar() {
    $("#txtIdpaciente").val("");
    $("#txtIdatencion").val("");
    $("#txtDni").val("");
    $("#txtNombres").val("");
    $("#txtApellidos").val("");
    $("#txtFecAte").val("");
    $("#txtTurno").val("MAÑANA").trigger('change');
    $("#txtNunSol").val("");
    $("#txtCantExa").val("1").trigger('change');
    $("#txtObservaciones").val("");
    selectProfesional();
    selectArea();
    $("#txtDni").prop('readOnly', false);
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);
    $("#btnGuardar").prop("disabled", true);
    $.ajax({
        url: "controllers/atencion.controller.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            $("#modalAtencion").modal("hide");
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: datos,
                showConfirmButton: false,
                timer: 4500,
            });
            tabla.ajax.reload();
        },
    });
    limpiar();
}

function eliminar(idatencion) {
    Swal.fire({
        icon: "question",
        title: 'Esta seguro en eliminar el registro?',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "controllers/atencion.controller.php?op=eliminar",
                { txtIdatencion: idatencion },
                function (data) {
                    data = JSON.parse(data);
                    Swal.fire({
                        position: "top-end",
                        icon: data["icono"],
                        title: data["mensaje"],
                        showConfirmButton: false,
                        timer: 4500,
                    });
                    tabla.ajax.reload();
                }
            );
        }
    })

}

init();