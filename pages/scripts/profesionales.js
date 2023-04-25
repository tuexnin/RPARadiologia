var tabla;
var tabla2;

function init() {
    listar();

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
    validarEntradaTexto("#txtProfesion", 250);

    $("#btnCancelar").click(function () { 
        limpiar();
    });

    $("#formulario").on("submit", function (e) {
        e.preventDefault();
        if($("#txtDni").val().length < 8 || $("#txtDni").val().length > 8){
            Swal.fire({
                icon: 'error',
                title: 'Error: El dni debe tener 8 caracteres'
            })
        }else if($("#txtNombres").val().length <= 0){
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese sus nombres'
            })
        }else if($("#txtApellidos").val().length <= 0){
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese sus apellidos'
            })
        }else if($("#txtProfesion").val().length <= 0){
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese su profesion'
            })
        }else if($("#txtCmp").val().length <= 0){
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese su CMP'
            })
        }else{
            guardaryeditar(e);
        }

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

//Función Listar
function listar() {
    tabla = $("#tbllistadoProfesionales")
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
                url: "controllers/profesionales.controller.php?op=listar",
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

function mostrar(idprofesional) {
    $("#tituloModal").text("Editar Profesional");
    $.post(
        "controllers/profesionales.controller.php?op=mostrar",
        { txtIdprofesional: idprofesional },
        function (data) {
            data = JSON.parse(data);

            $("#modalProfesional").modal("show");

            $("#txtIdprofesional").val(data[0]["idprofesional"]);
            $("#txtDni").val(data[0]["dni"]);
            $("#txtNombres").val(data[0]["nombres"]);
            $("#txtApellidos").val(data[0]["apellidos"]);
            $("#txtProfesion").val(data[0]["profesion"]);
            $("#txtCmp").val(data[0]["cmp"]);
        }
    );
}

function limpiar() {
    $("#txtIdprofesional").val("");
    $("#txtDni").val("");
    $("#txtNombres").val("");
    $("#txtApellidos").val("");
    $("#txtProfesion").val("");
    $("#txtCmp").val("");
    $("#tituloModal").text("Agregar Profesional");
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);
    $("#btnGuardar").prop("disabled", true);
    $.ajax({
        url: "controllers/profesionales.controller.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            $("#modalProfesional").modal("hide");
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

function activar(idprofesional) {
    Swal.fire({
        icon: "question",
        title: 'Esta seguro de activar al Profesional?',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "controllers/profesionales.controller.php?op=activar",
                { txtIdprofesional: idprofesional },
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

function desactivar(idprofesional) {
    Swal.fire({
        icon: "question",
        title: 'Esta seguro de desactivar al Profesional?',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "controllers/profesionales.controller.php?op=desactivar",
                { txtIdprofesional: idprofesional },
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

function verRegistro(idprofesional) {
    $("#modalRegAt").modal("show");
    $.post(
        "controllers/profesionales.controller.php?op=mostrar",
        { txtIdprofesional: idprofesional },
        function (data) {
            data = JSON.parse(data);
            $("#tituloModal2").text(data[0]["nombres"] + " " + data[0]["apellidos"]);
        }
    );
    tabla2 = $("#tbllistadoRegistros")
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
                url: "controllers/profesionales.controller.php?op=verRegistro",
                type: "post",
                dataType: "json",
                data: {
                    txtIdprofesional: idprofesional
                },
                error: function (e) {
                    console.log(e.responseText);
                },
            },
            bDestroy: true,
            iDisplayLength: 5, //Paginación
            order: [[0, "asc"]], //Ordenar (columna,orden)
        })
        .DataTable();

}

init();
