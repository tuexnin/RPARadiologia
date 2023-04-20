$(function(){
    
    $('#contenido').load('pages/dashboard.php');

    $('#btnDashboard').on("click", function (){
        $('#contenido').load('pages/dashboard.php');
    });

    $('#btnUsuarios').on("click", function (){
        $('#contenido').load('pages/usuarios.php');
    });

    $('#btnAreas').on("click", function (){
        $('#contenido').load('pages/areas.php');
    });

    $('#btnProfesionales').on("click", function (){
        $('#contenido').load('pages/profesionales.php');
    });

    $('#btnPacientes').on("click", function (){
        $('#contenido').load('pages/pacientes.php');
    });

    $('#btnAtenciones').on("click", function (){
        $('#contenido').load('pages/atenciones.php');
    });

    $('#btnCerrarSesion1').on("click", function (){
        cerrar();
    });

    $('#btnCerrarSesion2').on("click", function (){
        cerrar();
    });

})

function cerrar(){
    $.ajax({
        url: "controllers/login.controller.php?op=cerrar",
        type: "GET"
    }).done(function (respt) {
        Swal.fire({
            position: 'top-center',
            icon: 'info',
            title: 'Adios',
            text: 'Nos vemos..',
            showConfirmButton: false,
            timer: 4500
        }).then((result) => {
            location.reload(true);
        });
        
    });
}
