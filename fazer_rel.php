<!--
Página:
    iFrame de Relatórios de Serviço
Conteúdo:
    Exibe informações a respeito dos mapas locais (se quadra já foi trabalhada, número de residências, número de comercios e número de edifícios) e permite emitir relatórios.
-->

<?php
require_once 'phpaction/connect.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <!-- Compiled and minified CSS and Import Google Icon Font -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
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
                $sql = "SELECT id FROM mapas WHERE maps = '$i'";
                $stmt = conectar\Connect::conn()->prepare($sql);
                $stmt->execute();
                $dados_first = $stmt->fetch(\PDO::FETCH_BOTH);

                $sql = "SELECT id FROM mapas WHERE maps = '$i' ORDER BY id DESC";
                $stmt = conectar\Connect::conn()->prepare($sql);
                $stmt->execute();
                $dados_last = $stmt->fetch(\PDO::FETCH_BOTH);
                $stmt = conectar\Connect::closeConn();
                ?>
            <article id="<?php echo $i; ?>">
                <form action="phpaction/update_maps.php" method="POST">
                    <ul class="collapsible">
                        <?php
                        for ($j = $dados_first['id']; $j <= $dados_last['id']; $j++) {
                            $sql = "SELECT * FROM mapas WHERE id = '$j'";
                            $stmt = conectar\Connect::conn()->prepare($sql);
                            $stmt->execute();
                            $dados_quadra = $stmt->fetch(\PDO::FETCH_BOTH);
                            $stmt = conectar\Connect::closeConn();
                            ?>
                        <li>
                            <div class="collapsible-header">Quadra <?php echo $dados_quadra['quadra'] . (($dados_quadra['trab'] == 0) ? " não trabalhada" : " trabalhada"); ?> </div>
                            <div class="collapsible-body">
                                <div class="row">
                                    <div class="col s4" style="margin-top: -35px;">
                                        <input id="n_res_<?php echo $j; ?>" name="n_res_<?php echo $j; ?>" type="number" class="validate" value=<?php echo $dados_quadra['n_residencia']?>>
                                        <label for="n_res_<?php echo $j; ?>">Número de Residências</label>
                                    </div>
                                        
                                    <div class="col s4" style="margin-top: -35px;">
                                        <input id="n_com_<?php echo $j; ?>" name="n_com_<?php echo $j; ?>" type="number" class="validate" value=<?php echo $dados_quadra['n_comercio']?>>
                                        <label for="n_com_<?php echo $j; ?>">Número de Comércios</label>
                                    </div>
                                        
                                    <div class="col s4" style="margin-top: -35px;">
                                        <input id="n_edi_<?php echo $j; ?>" name="n_edi_<?php echo $j; ?>" type="number" class="validate" value=<?php echo $dados_quadra['n_edificio']?>>
                                        <label for="n_edi_<?php echo $j; ?>">Número de Edifícios</label>
                                    </div>
                                </div>
                                <div style="margin-bottom: -20px;">
                                    <label>
                                        <input type="checkbox" id="trab_<?php echo $j; ?>" name="trab_<?php echo $j; ?>" <?php echo(($dados_quadra['trab'] == 1) ? "checked" : "")?>>
                                        <span> Quadra Trabalhada</span>
                                    </label>
                                </div>
                            </div>
                        </li>
                            <?php
                        } ?>
                    </ul>
                    <input type="hidden" name="first" value="<?php echo $dados_first['id']; ?>">
                    <input type="hidden" name="last" value="<?php echo $dados_last['id']; ?>">
                    <input type="hidden" name="mapactive" value="<?php echo $i; ?>">
                    <button type="submit" name="btn-env-rel" class="btn teal darken-2">Enviar Relatório</button>
                </form>
            </article>
                <?php
            }
            ?>

        <script>
        $(document).ready(function(){
            $('.collapsible').collapsible({accordion: false});
        });
        </script>
    </body>   
</html>
