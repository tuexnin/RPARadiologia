var tabla;

function init() {
    listar();

    $("#btnCancelar").click(function () { 
        limpiar();
    });

    $("#formulario").on("submit", function (e) {
        e.preventDefault();
        if($("#txtNombre").val().length <= 0){
            Swal.fire({
                icon: 'error',
                title: 'Error: Ingrese el nombre del Area'
            })
        }else{
            guardaryeditar(e);
        }
        
    });
}

//Función Listar
function listar() {
    tabla = $("#tbllistadoAreas")
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
                { orderable: false, targets: [0] },
                //{ searchable: false, targets: [0] },
                //{ width: "30%", targets: [0] }
            ],
            responsive: true,
            ajax: {
                url: "controllers/areas.controller.php?op=listar",
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

function mostrar(idarea) {
    $("#tituloModal").text("Editar Area");
    $.post(
        "controllers/areas.controller.php?op=mostrar",
        { txtIdarea: idarea },
        function (data) {
            data = JSON.parse(data);

            $("#modalArea").modal("show");

            $("#txtIdarea").val(data[0]["idarea"]);
            $("#txtNombre").val(data[0]["nombre"]);
        }
    );
}

function limpiar() {
    $("#txtIdarea").val("");
    $("#txtNombre").val("");
    $("#tituloModal").text("Agregar Area");
}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);
    $("#btnGuardar").prop("disabled", true);
    $.ajax({
        url: "controllers/areas.controller.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            $("#modalArea").modal("hide");
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

function activar(idarea) {
    Swal.fire({
        icon: "question",
        title: 'Esta seguro de activar el area?',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "controllers/areas.controller.php?op=activar",
                { txtIdarea: idarea },
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

function desactivar(idarea) {
    Swal.fire({
        icon: "question",
        title: 'Esta seguro de desactivar el area?',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post(
                "controllers/areas.controller.php?op=desactivar",
                { txtIdarea: idarea },
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
