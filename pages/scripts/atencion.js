var tabla;

function init() {
    listar();

    validarDni();

    var today = new Date();

    // Restar 4 días a la fecha actual
    var minDate = new Date(today.getTime() - (3 * 24 * 60 * 60 * 1000));

    // Inicializar el plugin "bootstrap-datepicker" con las opciones deseadas
    $('#txtFecAte').datepicker({
        startDate: minDate,
        autoclose: true
    });

    $('#txtFecDesde').datepicker({
        endDate: today,
        autoclose: true
    });

    $('#txtFecAsta').datepicker({
        endDate: today,
        autoclose: true
    });

    validarNumeros("#txtDni",8);
    validarNumeros("#txtNunSol",6);

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

    $("#proF").select2();

    selectProfesional("#txtProfesional");
    selectProfesional("#proF");
    selectArea();

    $("#btnCancelar").click(function () {
        limpiar();
    });

    $("#formulario").on("submit", function (e) {
        
        e.preventDefault();
        if ($(this).valid()) {
            guardaryeditar(e);
        }
    });

    $("#formulario").validate({
        ignore: [txtObservaciones],
        errorClass: 'invalid-feedback animated fadeInDown',
        errorElement: 'div',
        errorPlacement: function(error, e) {
            jQuery(e).parents('.form-group').append(error);
        },
        highlight: function(e) {
            jQuery(e).closest('.form-group').removeClass('is-invalid').addClass('is-invalid');
        },
        success: function(e) {
            jQuery(e).closest('.form-group').removeClass('is-invalid');
            jQuery(e).remove();
        },
        rules: {
            txtDni: {
                required: true,
                minlength: 8
            },
            txtNombres: {
                required: true
            },
            txtApellidos: {
                required: true
            },
            txtFecAte: {
                required: true
            },
            txtTurno: {
                required: true
            },
            txtNunSol: {
                required: true
            },
            txtArea: {
                required: true
            },
            txtCantExa: {
                required: true
            },
            txtProfesional: {
                required: true
            }
        },
        messages: {
            txtDni: {
                required: "Por favor ingrese el DNI",
                minlength: 'El dni tiene minimo 8 digitos'
            },
            txtNombres: {
                required: "Por favor ingrese su nombre"
            },
            txtApellidos: {
                required: "Por favor ingrese sus apellidos"
            },
            txtFecAte: {
                required: "Por favor ingrese la fecha de atencion"
            },
            txtTurno: {
                required: "Por favor ingrese el turno"
            },
            txtNunSol: {
                required: "Por favor ingrese el numero de solicitud"
            },
            txtArea: {
                required: "Por favor seleccione el area"
            },
            txtCantExa: {
                required: "Por favor seleccione la cantidad de examenes"
            },
            txtProfesional: {
                required: "Por favor seleccione el profesional"
            }
        }
    });
}

function validarNumeros(campo, cant){
    $(campo).on("input", function () {
        var valor = $(this).val();
        var regex = /^[0-9]{0,cant}$/;
        if (!regex.test(valor)) {
            valor = valor.replace(/[^0-9]/g, "").substring(0, cant);
            $(this).val(valor);
        }
    });
}

function validarEntradaTexto(campo, cant) {
    $(campo).on("input", function () {
        var valor = $(this).val().toUpperCase();
        $(this).val(valor);
    }).on("keydown keyup", function (e) {
        var valor = $(this).val().toUpperCase();
        $(this).val(valor);
        if (e.type === "keydown") {
            if (e.key.match(/^[a-z]$/i) && $(this).val().length >= cant && e.keyCode !== 8 && e.keyCode !== 32 && e.keyCode !== 9) {
                e.preventDefault();
            } else if (!e.key.match(/^[a-z]$/i) && e.keyCode !== 8 && e.keyCode !== 32 && e.keyCode !== 9) {
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

function selectProfesional(campo) {
    $.post(
        "controllers/profesionales.controller.php?op=selectProfesional",
        function (data) {
            $(campo).html(data);
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

function filtrar() {
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
                url: "controllers/atencion.controller.php?op=filtrar",
                type: "post",
                dataType: "json",
                data: {
                    idprof: $("#proF").val(),
                    desde: $("#txtFecDesde").val(),
                    hasta: $("#txtFecAsta").val()
                },
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

function limpiarFiltro(){
    selectProfesional("#proF");
    $("#txtFecDesde").val("");
    $("#txtFecAsta").val("");
    listar();
}

init();