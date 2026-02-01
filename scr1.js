var segundoInicio = 3;

function actualizar() {
    document.getElementById('countdown').innerHTML = segundoInicio;

    if (segundoInicio == 0) {
        //cuenta regresiva ha finalizado
        window.location.href = "codigix.html";
    } else {

       // segundoInicio-=1;
        /* 0 */
        segundoInicio = segundoInicio -1;
        setTimeout(actualizar, 1E3);
    }
}

actualizar();