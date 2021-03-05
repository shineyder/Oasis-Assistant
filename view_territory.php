<?php

session_start();

/** Página:
*     Visualizar Território
*   Conteúdo:
*     Todos os mapas e sessão de relatório de serviço
*   Detalhes:
*     Exibição inicial tem o mapa do território todo da congregação (Mapa_Completo), com link para exibir o território de cada grupo (Mapa_Regio), nesse tem outro link para cada território individual (Mapa_Local).
*     A sessão de relatório de serviço só é exibida quando um Mapa_Local está em foco. Essa sessão está dentro de um iframe e exibe as informações atuais no sistema sobre cada quadra (se a quadra já foi trabalhada, número de residencias, número de comércios e número de edifícios). Nessa sessão também é possivel emitir um relatório de serviço e preencher ou atualizar as informações da quadra.*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

//Verificação
if (!isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/');
    exit();
endif;

//Dados
$publicador = unserialize($_SESSION['obj']);

// Header
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
// Message
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/message.php';
?>

<img id="Mapa_Completo" class="" src="mapas/Mapa_completo.jpg" alt="Mapa Completo" usemap="#Mapa_Completo">

<map name="Mapa_Completo">
    <area alt="Porto Novo 1" title="Porto Novo 1" href="#" onclick='edit("Porto_novo_1")'  coords="318,18,271,75,287,79,272,92,265,130,254,142,257,174,263,194,274,218,266,241,254,265,259,273,266,263,300,283,318,294,320,321,340,322,356,348,345,360,334,369,326,380,314,396,310,412,313,421,327,429,338,438,347,442,363,441,373,443,379,440,409,438,400,429,397,412,381,395,379,382,381,358,381,324,405,324,439,329,437,318,423,309,416,287,405,274,404,257,388,253,361,217,393,158,386,141,363,93,340,35" shape="poly">
    <area alt="Porto Novo 2" title="Porto Novo 2" href="#" onclick='edit("Porto_novo_2")' coords="318,304,213,299,205,318,163,327,136,269,95,287,55,297,50,319,51,349,97,395,88,411,95,426,112,430,137,409,171,422,192,414,188,404,206,377,223,362,244,359,258,384,259,401,259,421,255,447,253,470,261,504,274,497,269,474,267,453,277,456,285,449,303,457,341,464,350,455,346,444,326,434,310,421,306,410,312,399,323,381,332,367,355,347,338,324,318,323" shape="poly"> 
    <area alt="Bairro Aparecida" title="Bairro Aparecida" href="#" onclick='edit("Bairro_aparecida")' coords="90,730,140,726,153,673,141,653,120,662,113,657,115,640,127,620,154,607,184,610,198,631,213,632,257,633,269,623,262,612,286,588,282,564,270,532,260,504,251,484,251,458,255,432,257,399,252,379,243,363,225,365,207,378,191,404,196,412,186,426,147,461,128,457,104,472,74,540,101,596,113,609,97,642,103,666,100,696" shape="poly">
    <area alt="Presidente Medici" title="Presidente Medici" href="#" onclick='edit("Presidente_medici")' coords="271,457,276,496,279,531,287,555,292,579,303,594,312,625,326,655,342,677,358,652,376,624,379,591,389,554,389,526,406,511,403,482,395,464,412,440,384,442,374,445,367,443,350,443,354,455,342,466,302,459,286,454" shape="poly">
    <area alt="Morro Sesi" title="Morro Sesi" href="#" onclick='edit("Morro_Sesi")' coords="329,686,342,723,365,779,390,831,418,831,426,825,424,799,444,788,438,754,472,749,483,736,486,720,476,703,466,697,476,690,498,687,507,665,507,636,466,604,468,576,475,552,473,542,492,524,490,512,486,492,487,471,509,453,504,448,482,456,457,459,451,448,439,435,428,421,415,439,400,463,405,479,407,496,408,509,398,521,396,538,393,553,382,589,379,625,365,646,346,678" shape="poly">
    <area alt="Del Porto" title="Del Porto" href="#" onclick='edit("Del_porto")' coords="384,327,384,379,386,395,399,409,403,424,415,434,426,417,440,432,448,441,458,456,477,455,507,447,511,433,547,419,560,404,590,401,592,378,557,336,594,341,609,289,599,270,465,274,440,323,437,330,406,326" shape="poly">
</map>

<div id="Mapa_Regio" class="hide">

<img id="Porto_novo_1" class="hide" src="mapas/Porto_novo_1.jpg" alt="Mapa Regional" usemap="#Porto_novo_1">

<map name="Porto_novo_1">
    <area target="rel" alt="24" title="24" href="report.php#24" onclick='edit2("24")' coords="199,28,106,142,129,150,116,166,104,246,85,254,92,328,86,373,89,429,70,467,98,498,111,485,159,503,164,546,195,545,203,534,207,468,222,438,232,397,244,386,259,386,269,402,300,342,333,308,340,273,326,265,302,293,322,238,265,100,240,69,218,42" shape="poly">
    <area target="rel" alt="23" title="23" href="report.php#23" onclick='edit2("23")' coords="206,587,292,583,358,589,424,600,424,582,381,572,382,558,368,552,375,529,385,508,373,470,327,465,271,405,256,389,244,388,234,399,227,428,210,465,206,525" shape="poly">
    <area target="rel" alt="12" title="12" href="report.php#12" onclick='edit2("12")' coords="251,593,313,593,313,653,313,706,320,727,343,749,359,784,359,796,316,801,294,810,256,807,241,793,218,786,192,765,187,743,196,719,217,691,235,667,251,649,269,638" shape="poly">
</map>

<img id="Porto_novo_2" class="hide" src="mapas/Porto_novo_2.jpg" alt="Mapa Regional" usemap="#Porto_novo_2">

<map name="Porto_novo_2">
    <area target="rel" alt="8" title="8" href="report.php#8" onclick='edit2("8")' coords="37,126,43,278,180,427,153,461,169,504,220,475,230,500,269,474,482,492,485,451,455,447,468,420,435,378,454,356,459,316,422,286,399,282,372,286,339,66,278,46,171,92,89,104" shape="poly">
    <area target="rel" alt="13" title="13" href="report.php#13" onclick='edit2("13")' coords="430,285,464,316,460,355,441,377,469,417,545,338,628,313,674,383,680,456,656,618,655,697,685,763,701,749,730,739,712,644,704,601,736,608,760,588,814,610,937,640,961,604,952,567,850,496,835,457,843,425,903,351,986,274,938,200,870,198,865,104,806,104,796,182,710,196,549,144,513,232,481,269" shape="poly">
</map>

<img id="Bairro_aparecida" class="hide" src="mapas/Bairro_aparecida.jpg" alt="Mapa Regional" usemap="#Bairro_aparecida">

<map name="Bairro_aparecida">
    <area target="rel" alt="1" title="1" href="report.php#1" onclick='edit2("1")' coords="161,579,211,584,257,568,298,578,330,621,362,628,374,617,458,630,466,624,471,608,467,592,531,527,552,578,559,572,560,541,545,529,528,489,520,485,515,475,495,449,492,471,470,477,440,464,410,486,385,496,347,494,343,538,296,514,287,543,227,552,189,557,173,565" shape="poly">
    <area target="rel" alt="2" title="2" href="report.php#2" onclick='edit2("2")' coords="299,513,337,532,345,489,378,490,415,476,434,458,455,468,472,474,489,468,490,452,486,436,463,405,441,367,410,382,397,385,387,383,371,338,344,316,337,339,291,327,289,346,285,395,283,429,287,459,299,494" shape="poly">
    <area target="rel" alt="3" title="3" href="report.php#3" onclick='edit2("3")' coords="502,448,452,305,452,257,433,255,431,231,411,226,403,229,376,231,372,240,334,226,290,320,335,334,342,311,362,326,376,340,391,382,402,380,421,373,441,365,473,414,490,438" shape="poly">
    <area target="rel" alt="4" title="4" href="report.php#4" onclick='edit2("4")' coords="435,249,452,253,465,173,466,95,453,70,431,34,392,43,349,73,333,88,309,138,329,129,348,109,362,96,358,122,357,146,355,160,335,224,368,234,377,225,405,226,412,221,433,226" shape="poly">
    <area target="rel" alt="5" title="5" href="report.php#5" onclick='edit2("5")' coords="155,570,166,554,183,526,183,512,217,463,195,453,235,322,184,245,141,280,71,401,55,420,122,551" shape="poly">
    <area target="rel" alt="6" title="6" href="report.php#6" onclick='edit2("6")' coords="163,564,189,552,286,537,298,502,282,462,279,422,285,371,287,324,318,253,344,184,354,152,359,105,332,131,321,181,291,236,260,262,238,322,204,454,221,460,188,512,188,529" shape="poly">
    <area target="rel" alt="7" title="7" href="report.php#7" onclick='edit2("7")' coords="116,701,105,832,220,832,242,731,217,679" shape="poly">
</map>

<img id="Presidente_medici" class="hide" src="mapas/Presidente_medici.jpg" alt="Mapa Regional" usemap="#Presidente_medici">

<map name="Presidente_medici">
    <area target="rel" alt="9" title="9" href="report.php#9" onclick='edit2("9")' coords="148,356,120,396,97,413,97,446,124,512,166,530,192,557,215,569,280,565,318,557,349,539,357,522,366,517,378,491,398,414,413,365,415,316,394,327,378,380,363,350,339,314,327,308,318,273,295,286,279,293,252,303,201,332" shape="poly">
    <area target="rel" alt="10" title="10" href="report.php#10" onclick='edit2("10")' coords="95,407,73,339,69,261,44,201,39,158,32,90,61,99,78,86,104,85,191,117,259,129,263,140,295,160,310,192,313,218,313,261,278,285,253,294,203,326,169,342,144,352,117,393" shape="poly">
    <area target="rel" alt="11" title="11" href="report.php#11" onclick='edit2("11")' coords="283,67,297,57,344,59,376,51,475,37,426,120,428,141,444,161,453,188,452,216,453,258,431,289,412,311,391,325,378,370,366,345,345,312,333,304,321,270,316,206,301,160,266,135,288,103" shape="poly">
    <area target="rel" alt="15" title="15" href="report.php#15" onclick='edit2("15")' coords="149,526,148,561,188,665,232,767,259,798,265,777,284,745,331,672,360,633,371,605,371,519,359,522,355,539,332,556,317,563,295,568,218,574,189,562,167,534" shape="poly">
</map>

<img id="Morro_Sesi" class="hide" src="mapas/Morro_Sesi.jpg" alt="Mapa Regional" usemap="#Morro_Sesi">

<map name="Morro_Sesi">
    <area target="rel" alt="14" title="14" href="report.php#14" onclick='edit2("14")' coords="33,510,98,691,110,695,140,789,212,768,203,739,205,710,238,690,235,632,307,594,295,546,269,554,274,534,289,528,285,498,244,487,187,490,148,482,106,475,77,469,59,507" shape="poly">
    <area target="rel" alt="16" title="16" href="report.php#16" onclick='edit2("16")' coords="153,478,186,487,229,484,249,484,288,498,292,518,322,517,346,499,354,478,352,427,275,355,281,305,284,271,240,272,230,326,223,329,207,319,167,318,176,350,174,376,175,390,186,402,192,418,202,423,210,450,182,452,157,448,140,434,131,441,137,455,152,460" shape="poly">
    <area target="rel" alt="17" title="17" href="report.php#17" onclick='edit2("17")' coords="81,466,150,481,150,462,132,452,128,443,137,429,153,441,186,450,206,446,198,423,190,420,184,403,171,390,169,372,173,350,162,317,183,315,209,317,225,326,232,305,232,269,220,261,188,269,148,277,140,282,127,334,126,361,122,405,95,437" shape="poly">
    <area target="rel" alt="18" title="18" href="report.php#18" onclick='edit2("18")' coords="143,275,219,258,237,266,283,269,294,248,321,227,325,205,315,186,321,162,329,139,357,80,320,85,301,52,241,58,211,23,158,107,170,138,172,178,151,213,149,241" shape="poly">
</map>

<img id="Del_porto" class="hide" src="mapas/Del_porto.jpg" alt="Mapa Regional" usemap="#Del_porto">

<map name="Del_porto">
    <area target="rel" alt="19" title="19" href="report.php#19" onclick='edit2("19")' coords="353,427,409,447,504,403,515,369,538,294,498,289,444,266,401,251" shape="poly">
    <area target="rel" alt="20" title="20" href="report.php#20" onclick='edit2("20")' coords="290,566,358,474,401,450,348,429,378,326,396,251,257,226,188,223,190,416,204,455,239,486,255,540,272,559" shape="poly">
    <area target="rel" alt="21" title="21" href="report.php#21" onclick='edit2("21")' coords="333,514,358,480,482,422,507,408,546,295,630,293,636,314,678,318,728,399,818,378,838,400,839,440,798,466,731,470,712,509,628,544,614,512,571,481,539,502,565,517,585,551,536,577,538,627,414,633,372,584,348,542" shape="poly">
    <area target="rel" alt="22" title="22" href="report.php#22" onclick='edit2("22")' coords="387,244,409,251,457,269,498,287,544,290,631,290,639,313,677,313,758,237,827,255,846,214,831,161,830,103,493,75,453,90,459,185,394,227" shape="poly">
</map>

</div>

<img id="Mapa_Local" class="hide" src="mapas/1.jpg" alt="Mapa Local">

<button id="voltar1" href="#" onclick="volt1()" class="hide">Voltar</button>
<button id="voltar2" href="#" onclick="volt2()" class="hide">Voltar</button>

<script>
function edit(param) {
    document.getElementById(param).setAttribute("class", "");
    document.getElementById("Mapa_Regio").setAttribute("class", "");
    document.getElementById("Mapa_Completo").setAttribute("class", "hide");
    document.getElementById("voltar1").setAttribute("class", "btn-small red darken-2");
}

function edit2(param) {
    document.getElementById("Mapa_Local").setAttribute("class", "");
    document.getElementById("Mapa_Local").setAttribute("src", "mapas/" + param + ".jpg");
    document.getElementById("Mapa_Regio").setAttribute("class", "hide");
    document.getElementById("frame-rel").setAttribute("class", "");    
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
    document.getElementById("frame-rel").setAttribute("class", "hide");
    document.getElementById("voltar1").setAttribute("class", "btn-small red darken-2");
    document.getElementById("voltar2").setAttribute("class", "hide");
}
</script>

<div class="iframes">
    <iframe scrolling="no" src="report.php" name="rel" id="frame-rel" class="hide"></iframe>
</div>

<script>
    imageMapResize();
</script>

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>