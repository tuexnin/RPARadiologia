var tabla;
var tabla2;

function init() {
    listar();

    $("#btnCancelar").click(function () { 
        limpiar();
    });

    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    });
}

//Función Listar
function listar() {
    tabla = $("#tbllistadoPacientes")
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
                url: "controllers/pacientes.controller.php?op=listar",
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

function mostrar(idpaciente) {
    $.post(
        "controllers/pacientes.controller.php?op=mostrar",
        { txtIdpaciente: idpaciente },
        function (data) {
            data = JSON.parse(data);

            $("#modalPaciente").modal("show");

            $("#txtIdpaciente").val(data[0]["idpaciente"]);
            $("#txtDni").val(data[0]["dni"]);
            $("#txtNombres").val(data[0]["nombres"]);
            $("#txtApellidos").val(data[0]["apellidos"]);
        }
    );
}

function limpiar() {
    $("#txtIdpaciente").val("");
    $("#txtDni").val("");
    $("#txtNombres").val("");
    $("#txtApellidos").val("");
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);
    $("#btnGuardar").prop("disabled", true);
    $.ajax({
        url: "controllers/pacientes.controller.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            $("#modalPaciente").modal("hide");
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

function verRegistro(idpaciente) {
    $("#modalRegAt").modal("show");
    $.post(
        "controllers/pacientes.controller.php?op=mostrar",
        { txtIdpaciente: idpaciente },
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
                url: "controllers/pacientes.controller.php?op=verRegistro",
                type: "post",
                dataType: "json",
                data: {
                    txtIdpaciente: idpaciente
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