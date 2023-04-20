
function init() {
    
    turno("#turnoM", "MAÑANA");
    turno("#turnoT", "TARDE");
    turno("#turnoN", "NOCHE");
    consulta("atencion", "#cantReg");
    consulta("pacientes", "#cantP");
    consulta("profesionales", "#cantPro");
    consulta("areas", "#cantAr");

}

function turno(obj, valor){
    $.post(
        "controllers/atencion.controller.php?op=turno",
        {txtTurno : valor},
        function (data) {
            data = JSON.parse(data);
            $(obj).text(data[0]["cantidad"]);
        }
    );
}

function consulta(ruta, obj){
    $.post(
        "controllers/"+ruta+".controller.php?op=cantidad",
        function (data) {
            data = JSON.parse(data);
            $(obj).text(data[0]["cantidad"]);
        }
    );
}

init();
