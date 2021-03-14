<?php

/** Página: Visualizar Território
*   Conteúdo: Todos os mapas e sessão de relatório de serviço
*   Detalhes: Exibição inicial tem o mapa do território todo da congregação (Mapa_Completo em index), com link para exibir o território de cada grupo (Mapa_Regio em mapaRegio), nesse tem outro link para cada território individual (Mapa_Local em mapaLoc).
*     A sessão de relatório de serviço só é exibida quando um Mapa_Local está em foco. Essa sessão está dentro de um iframe e exibe as informações atuais no sistema sobre cada quadra (se a quadra já foi trabalhada, número de residencias, número de comércios e número de edifícios). Nessa sessão também é possivel emitir um relatório de serviço e preencher ou atualizar as informações da quadra.
*/

?>

<img class="map" src=<?php echo URL . "_img/maps/Mapa_completo.jpg";?> alt="Mapa Completo" usemap="#Mapa_Completo">

<map name="Mapa_Completo">
    <area alt="Porto Novo 1" title="Porto Novo 1" href=<?php echo URL . "territory/showRegio/Porto_novo_1";?> coords="318,18,271,75,287,79,272,92,265,130,254,142,257,174,263,194,274,218,266,241,254,265,259,273,266,263,300,283,318,294,320,321,340,322,356,348,345,360,334,369,326,380,314,396,310,412,313,421,327,429,338,438,347,442,363,441,373,443,379,440,409,438,400,429,397,412,381,395,379,382,381,358,381,324,405,324,439,329,437,318,423,309,416,287,405,274,404,257,388,253,361,217,393,158,386,141,363,93,340,35" shape="poly">
    <area alt="Porto Novo 2" title="Porto Novo 2" href=<?php echo URL . "territory/showRegio/Porto_novo_2";?> coords="318,304,213,299,205,318,163,327,136,269,95,287,55,297,50,319,51,349,97,395,88,411,95,426,112,430,137,409,171,422,192,414,188,404,206,377,223,362,244,359,258,384,259,401,259,421,255,447,253,470,261,504,274,497,269,474,267,453,277,456,285,449,303,457,341,464,350,455,346,444,326,434,310,421,306,410,312,399,323,381,332,367,355,347,338,324,318,323" shape="poly"> 
    <area alt="Bairro Aparecida" title="Bairro Aparecida" href=<?php echo URL . "territory/showRegio/Bairro_aparecida";?> coords="90,730,140,726,153,673,141,653,120,662,113,657,115,640,127,620,154,607,184,610,198,631,213,632,257,633,269,623,262,612,286,588,282,564,270,532,260,504,251,484,251,458,255,432,257,399,252,379,243,363,225,365,207,378,191,404,196,412,186,426,147,461,128,457,104,472,74,540,101,596,113,609,97,642,103,666,100,696" shape="poly">
    <area alt="Presidente Medici" title="Presidente Medici" href=<?php echo URL . "territory/showRegio/Presidente_medici";?> coords="271,457,276,496,279,531,287,555,292,579,303,594,312,625,326,655,342,677,358,652,376,624,379,591,389,554,389,526,406,511,403,482,395,464,412,440,384,442,374,445,367,443,350,443,354,455,342,466,302,459,286,454" shape="poly">
    <area alt="Morro Sesi" title="Morro Sesi" href=<?php echo URL . "territory/showRegio/Morro_Sesi";?> coords="329,686,342,723,365,779,390,831,418,831,426,825,424,799,444,788,438,754,472,749,483,736,486,720,476,703,466,697,476,690,498,687,507,665,507,636,466,604,468,576,475,552,473,542,492,524,490,512,486,492,487,471,509,453,504,448,482,456,457,459,451,448,439,435,428,421,415,439,400,463,405,479,407,496,408,509,398,521,396,538,393,553,382,589,379,625,365,646,346,678" shape="poly">
    <area alt="Del Porto" title="Del Porto" href=<?php echo URL . "territory/showRegio/Del_porto";?> coords="384,327,384,379,386,395,399,409,403,424,415,434,426,417,440,432,448,441,458,456,477,455,507,447,511,433,547,419,560,404,590,401,592,378,557,336,594,341,609,289,599,270,465,274,440,323,437,330,406,326" shape="poly">
</map>

<script type = "text/javascript" src=<?php echo URL . "_public/_JS/imageMapResizer.min.js";?>></script>

<script>
    imageMapResize();
</script>