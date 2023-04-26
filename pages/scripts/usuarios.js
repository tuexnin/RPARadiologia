var tabla;

function init() {
    listar();

    $("#imagenmuestra").hide();

    $("#btnCancelar").click(function () {
        limpiar();
    });

    $("#formulario").on("submit", function (e) {
        e.preventDefault();
        if ($("#txtDni").val().length < 8 || $("#txtDni").val().length > 8) {
            Swal.fire({
                icon: 'error',
                title: 'Error: El dni debe tener 8 caracteres'
            })
        } else if ($("#txtNombres").val().length <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese sus nombres'
            })
        } else if ($("#txtApellidos").val().length <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese sus apellidos'
            })
        } else if ($("#txtUsuario").val().length <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese su nombre de usuario'
            })
        } else if ($("#txtPassword").val().length <= 0 && $("#txtContraseña").val().length <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese su contraseña'
            })
        } else if ($("#txtRol").val().length <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error: Seleccione un rol'
            })
        } else {
            guardaryeditar(e);
        }

    });
}

//Función Listar
function listar() {
    tabla = $("#tbllistadoUsuarios")
        .dataTable({
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
                { orderable: false, targets: [0, 3] },
                { searchable: false, targets: [0, 3] },
                //{ width: "30%", targets: [0] }
            ],
            responsive: true,
            ajax: {
                url: "controllers/usuarios.controller.php?op=listar",
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

function mostrar(idusuario) {
    $("#tituloModal").text("Editar Usuario");
    $.post(
        "controllers/usuarios.controller.php?op=mostrar",
        { txtIdusuario: idusuario },
        function (data) {
            data = JSON.parse(data);

            $("#modalUsuario").modal("show");

            $("#txtIdusuario").val(data[0]["idusuario"]);
            $("#txtContraseña").val(data[0]["password"]);
            $("#txtNombres").val(data[0]["nombres"]);
            $("#txtApellidos").val(data[0]["apellidos"]);
            $("#txtDni").val(data[0]["dni"]);
            $("#txtCelular").val(data[0]["celular"]);
            $("#txtEmail").val(data[0]["correo"]);
            $("#txtUsuario").val(data[0]["usuario"]);
            $("#txtPassword").val("");
            $("#imagenmuestra").attr("src", data[0]["foto"] == null || data[0]["foto"] == "" ? "" : "files/fotos/" + data[0]["foto"]);
            $("#imagenactual").val(data[0]["foto"]);
            $("#txtRol").val(data[0]["rol"]);
            data[0]["foto"] == null || data[0]["foto"] == "" ? $("#imagenmuestra").hide() : $("#imagenmuestra").show();
        }
    );
}

function limpiar() {
    $("#txtIdusuario").val("");
    $("#txtDni").val("");
    $("#txtNombres").val("");
    $("#txtApellidos").val("");
    $("#txtCelular").val("");
    $("#txtEmail").val("");
    $("#txtUsuario").val("");
    $("#txtPassword").val("");
    $("#txtContraseña").val("");
    $("#tituloModal").text("Agregar Usuario");
    $("#imagenmuestra").attr("src", "");
    $("#imagenactual").val("");
    $("#txtRol").val("SELECCIONE");
    $("#txtImagen").val("");
    $("#imagenmuestra").hide();
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);
    $("#btnGuardar").prop("disabled", true);
    $.ajax({
        url: "controllers/usuarios.controller.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            $("#modalUsuario").modal("hide");
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

function eliminar(idusuario) {
    Swal.fire({
        icon: "question",
        title: 'Esta seguro en eliminar el usuario?',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "controllers/usuarios.controller.php?op=eliminar",
                { txtIdusuario: idusuario },
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
