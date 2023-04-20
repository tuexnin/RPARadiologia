var tabla;

function init (){

    $("#formulario").on("submit", function (e)
    {
        e.preventDefault();
        if($("#login-username").val().length <= 0){
            Swal.fire({
                icon: 'error',
                title: 'Error: Tiene que ingresar un usuario'
            })
        }else if($("#login-password").val().length <= 0){
            Swal.fire({
                icon: 'error',
                title: 'Error: Tiene que ingresar una contraseña'
            })
        }else{
            ingresar(e);
        }
        
    })

}

function limpiar(){
    $("#login-username").val("");
    $("#login-password").val("");
}

function ingresar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "controllers/login.controller.php?op=validar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos)
        {    
            if (datos == 0){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error: Usuario no existe',
                    showConfirmButton: false,
                    timer: 4500
                });
                limpiar();
            }else{
                data = JSON.parse(datos);
                if(data[0][0] == 'no password'){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: data[0][1],
                        text: 'Contraña incorrecta',
                        showConfirmButton: false,
                        timer: 4500
                    });
                }else{
                    $.ajax({
                        url: "controllers/login.controller.php?op=iniciar",
                        type: "POST",
                        data:{
                            idusuario : data[0][0],
                            nombres : data[0][1],
                            usuario : data[0][2],
                            idrol : data[0][4]
                        }
                    }).done(function(respt){
                        Swal.fire({
                            position: 'top-center',
                            icon: 'success',
                            title: 'Bienvenido ' + data[0][1],
                            text: 'Datos correctos',
                            showConfirmButton: false,
                            timer: 4500
                        }).then((result) => {
                            location.reload(true);
                        });
                    });
                }
            }

        }

    });
    
}

init();