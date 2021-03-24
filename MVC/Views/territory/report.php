<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <!-- Compiled and minified CSS and Import Google Icon Font -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <!-- Toastr -->
        <link rel="stylesheet" href=<?php echo URL . "_public/_CSS/toastr.min.css";?>>
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <style>
            article{height: 50000px;}
            body{display: block;}
        </style>
    </head>

    <script>
    function myFunction(param){
        if (document.getElementById("work_" + param).checked) {
            document.getElementById("data-" + param).setAttribute("class", "");
        } else {
            document.getElementById("data-" + param).setAttribute("class", "hide");
        }
    }
    </script>

    <body>
        <div class="container">
            <form action=<?php echo URL . "Territory/updateMaps/" . $this->reportLoc
            ;?> method="POST">
                <ul class="collapsible">
                    <?php
                    foreach ($this->data as $dados_quadra) :
                        ?>
                        <li>
                            <div class="collapsible-header">Quadra <?php echo $dados_quadra->getQuadra() . (($dados_quadra->getWorked() == 0) ? " não trabalhada" : " trabalhada");?> </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div>
                                        <label>
                                            <?php
                                            if ($dados_quadra->getWorked() == 1) :
                                                ?>
                                                <input type="hidden" id="work_<?php echo $dados_quadra->getId();?>" name="work_<?php echo $dados_quadra->getId();?>" value = "1">
                                                <?php
                                            else :
                                                ?>
                                                <input type="checkbox" id="work_<?php echo $dados_quadra->getId();?>" name="work_<?php echo $dados_quadra->getId();?>" onclick='myFunction(<?php echo $dados_quadra->getId();?>)' <?php echo(($dados_quadra->getWorked() == 1) ? "checked = 'checked' disabled = 'disabled'" : "")?>>
                                                <span> Quadra Trabalhada</span>
                                                <?php
                                            endif;
                                            ?>
                                        </label>
                                    </div>
                                <?php
                                if ($dados_quadra->getWorked() == 1) :
                                    ?>
                                    <div class="col s12">
                                        <span> Número de Residências: <?php echo $dados_quadra->getRes()?></span><br>
                                        <span> Número de Comércios: <?php echo $dados_quadra->getCom()?></span><br>
                                        <span> Número de Edifícios: <?php echo $dados_quadra->getEdi()?></span>
                                    </div>
                                    <input type="hidden" id="n_res_<?php echo $dados_quadra->getId();?>" name="n_res_<?php echo $dados_quadra->getId();?>" type="number" value=<?php echo $dados_quadra->getRes()?>>
                                    <input type="hidden" id="n_com_<?php echo $dados_quadra->getId();?>" name="n_com_<?php echo $dados_quadra->getId();?>" type="number" value=<?php echo $dados_quadra->getCom()?>>
                                    <input type="hidden" id="n_edi_<?php echo $dados_quadra->getId();?>" name="n_edi_<?php echo $dados_quadra->getId();?>" type="number" value=<?php echo $dados_quadra->getEdi()?>>
                                    <?php
                                else :
                                    ?>
                                    <div id="data-<?php echo $dados_quadra->getId();?>" class="hide">
                                        <div class="col s4">
                                            <input id="n_res_<?php echo $dados_quadra->getId();?>" name="n_res_<?php echo $dados_quadra->getId();?>" type="number" class="validate" value=<?php echo $dados_quadra->getRes()?> min="0">
                                            <label for="n_res_<?php echo $dados_quadra->getId();?>">Número de Residências</label>
                                        </div>

                                        <div class="col s4">
                                            <input id="n_com_<?php echo $dados_quadra->getId();?>" name="n_com_<?php echo $dados_quadra->getId();?>" type="number" class="validate" value=<?php echo $dados_quadra->getCom()?> min="0">
                                            <label for="n_com_<?php echo $dados_quadra->getId();?>">Número de Comércios</label>
                                        </div>

                                        <div class="col s4">
                                            <input id="n_edi_<?php echo $dados_quadra->getId();?>" name="n_edi_<?php echo $dados_quadra->getId();?>" type="number" class="validate" value=<?php echo $dados_quadra->getEdi()?> min="0">
                                            <label for="n_edi_<?php echo $dados_quadra->getId();?>">Número de Edifícios</label>
                                        </div>
                                    </div>
                                    <?php
                                endif;
                                ?>
                                </div>
                            </div>
                        </li>
                        <?php
                    endforeach;
                    ?>
                </ul>
                    <input type="hidden" name="mapactive" value="<?php echo $this->reportLoc;?>">
                    <button type="submit" name="btn-env-rel" class="btn teal darken-2">Enviar Relatório</button>
            </form>
        </div>

        <!-- Compiled and minified JavaScript -->
        <script type = "text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-alpha.4/js/materialize.min.js"></script>
        <!-- Toastr -->
        <script src=<?php echo URL . "_public/_JS/toastr.min.js";?>></script>

        <script>
        $(document).ready(function() {
            $('.collapsible').collapsible({accordion: false});
        })
        </script>
    </body>   
</html>