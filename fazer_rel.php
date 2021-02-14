<!--
Página:
    iFrame de Relatórios de Serviço
Conteúdo:
    Exibe informações a respeito dos mapas locais (se quadra já foi trabalhada, número de residências, número de comercios e número de edifícios) e permite emitir relatórios.
-->

<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Mapa e MapaDAO
require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/mapa.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/mapaDao.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <!-- Compiled and minified CSS and Import Google Icon Font -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    
        <!-- Compiled and minified JavaScript -->
        <script type = "text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <style>
            article{
                height: 50000px;
            }
            body{
                display: block;
            }
        </style>
    </head>

    <body> 
        <div class="container">
            <?php
            for ($i = 1; $i <= 24; $i++) {
                $mapaDAO = Mapa\MapasDAO::getInstance()->firstLast($i);
                ?>
                <article id="<?php echo $i; ?>">
                    <form action="phpaction/update_maps.php" method="POST">
                        <ul class="collapsible">
                            <?php
                            for ($j = $mapaDAO[0]["id"]; $j <= $mapaDAO[1]["id"]; $j++) {
                                $dados_quadra = Mapa\MapasDAO::getInstance()->read($j);
                                ?>
                                <li>
                                    <div class="collapsible-header">Quadra <?php echo $dados_quadra->getQuadra() . (($dados_quadra->getTrab() == 0) ? " não trabalhada" : " trabalhada"); ?> </div>
                                    <div class="collapsible-body">
                                        <div class="row">
                                            <div class="col s4" style="margin-top: -35px;">
                                                <input id="n_res_<?php echo $j; ?>" name="n_res_<?php echo $j; ?>" type="number" class="validate" value=<?php echo $dados_quadra->getRes()?> min="0">
                                                <label for="n_res_<?php echo $j; ?>">Número de Residências</label>
                                            </div>
                                                
                                            <div class="col s4" style="margin-top: -35px;">
                                                <input id="n_com_<?php echo $j; ?>" name="n_com_<?php echo $j; ?>" type="number" class="validate" value=<?php echo $dados_quadra->getCom()?> min="0">
                                                <label for="n_com_<?php echo $j; ?>">Número de Comércios</label>
                                            </div>
                                                
                                            <div class="col s4" style="margin-top: -35px;">
                                                <input id="n_edi_<?php echo $j; ?>" name="n_edi_<?php echo $j; ?>" type="number" class="validate" value=<?php echo $dados_quadra->getEdi()?> min="0">
                                                <label for="n_edi_<?php echo $j; ?>">Número de Edifícios</label>
                                            </div>
                                        </div>
                                        <div style="margin-bottom: -20px;">
                                            <label>
                                                <input type="checkbox" id="trab_<?php echo $j; ?>" name="trab_<?php echo $j; ?>" <?php echo(($dados_quadra->getTrab() == 1) ? "checked = 'checked' disabled = 'disabled'" : "")?>>
                                                <span> Quadra Trabalhada</span>
                                            </label>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                            <input type="hidden" name="first" value="<?php echo $mapaDAO[0]["id"]; ?>">
                            <input type="hidden" name="last" value="<?php echo $mapaDAO[1]["id"]; ?>">
                            <input type="hidden" name="mapactive" value="<?php echo $i; ?>">
                            <button type="submit" name="btn-env-rel" class="btn teal darken-2">Enviar Relatório</button>
                    </form>
                </article>
                <?php
            }
            ?>

        <script>
        $(document).ready(function() {
            $('.collapsible').collapsible({accordion: false});
        })
        </script>
    </body>   
</html>
