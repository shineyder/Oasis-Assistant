
<script type = "text/javascript" src=<?php echo URL . "_public/_JS/imageMapResizer.min.js";?>></script>

<script>
    imageMapResize();
</script>

<script>
function edit(param) {
    document.getElementById(param).setAttribute("class", "");
    document.getElementById("Mapa_Regio").setAttribute("class", "");
    document.getElementById("Mapa_Completo").setAttribute("class", "hide");
    document.getElementById("voltar1").setAttribute("class", "btn-small red darken-2");
}

function edit2(param) {
    document.getElementById("Mapa_Local").setAttribute("class", "");
    document.getElementById("Mapa_Local_img").setAttribute("src", <?php echo URL;?> + "_img/maps/" . param + ".jpg");
    document.getElementById("Mapa_Regio").setAttribute("class", "hide");
    document.getElementById("div-rel").setAttribute("class", "");    
    document.getElementById("voltar1").setAttribute("class", "hide");
    document.getElementById("voltar2").setAttribute("class", "btn-small red darken-2");
}

function volt1() {
    document.getElementById("Mapa_Completo").setAttribute("class", "");
    document.getElementById("Mapa_Regio").setAttribute("class", "hide");
    document.getElementById("Porto_novo_1").setAttribute("class", "hide");
    document.getElementById("Porto_novo_2").setAttribute("class", "hide");
    document.getElementById("Bairro_aparecida").setAttribute("class", "hide");
    document.getElementById("Presidente_medici").setAttribute("class", "hide");
    document.getElementById("Morro_Sesi").setAttribute("class", "hide");
    document.getElementById("Del_porto").setAttribute("class", "hide");
    document.getElementById("voltar1").setAttribute("class", "hide");
}

function volt2() {
    document.getElementById("Mapa_Regio").setAttribute("class", "");
    document.getElementById("Mapa_Local").setAttribute("class", "hide");
    document.getElementById("div-rel").setAttribute("class", "hide");
    document.getElementById("voltar1").setAttribute("class", "btn-small red darken-2");
    document.getElementById("voltar2").setAttribute("class", "hide");
}
</script>

<script>
    /*Pega o evento de Load da pagina*/
    (function() {

    /*Pega a url atual*/
    var urlAtual = window.location.href;

    /*Seta a url para chamar a função*/
    var urlParaRedirecionar = <?php echo URL;?>;

    /*verifica se é para execultar a função, se sim, ele a execulta*/
    if(urlAtual != urlParaRedirecionar) {
        edit();
    }

    })();
</script>