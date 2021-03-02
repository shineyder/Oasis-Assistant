<!--
Página:
    Meus Relatórios
Conteúdo:
    Apresenta todos os relatórios feitos pelo usuário e permite alterar ou deletar relatórios feitos nas últimas 24hrs.
-->
<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\PublicadorDAO;
use Assistant\EventoDAO;
use Assistant\MapasDao;

// Sessão
session_start();

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

if ($publicador->getAccess() >= 8) :
    $totId = PublicadorDAO::getInstance()->lastId();
    $totId = intval($totId['id']);
    ?>
    <p><h4>Ver relatórios de:</h4></p><br>

    <script>
        $(document).ready(function(){
            $('select').formSelect();
        });
    </script>

    <form action="#" method="POST">
        <div class="input-field">
            <select id="publicador" name="publicador">
            <option value="" disabled selected>Selecione uma opção</option>
            <?php
            for ($i = 1; $i <= $totId; $i++) :
                $nome = PublicadorDAO::getInstance()->read('id', $i, 'nome, sobrenome')->fetch(\PDO::FETCH_BOTH);
                ?>
                <option value="<?php echo $i; ?>"><?php echo $nome["nome"] . " " . $nome["sobrenome"];?></option>
                <?php
            endfor;
            ?>
            </select>
        </div>
        <button type="submit" name="btn-pub" class="btn blue darken-2">Próximo</button>
    </form>
    <?php
else :
    $ver = 0;
endif;
?>

<?php
if (($publicador->getAccess() >= 8 and isset($_POST['btn-pub'])) or $publicador->getAccess() < 8) :
    if (isset($ver)) :
        $pub = $publicador->getId();
    else :
        $pub = $_POST['publicador'];
    endif;
    ?>
    <h4>Relatórios feitos:</h4>

    <ul class="collapsible">
        <?php
        $cob = EventoDAO::getInstance()->cobertNow();
        for ($j = 1; $j <= $cob; $j++) :
            $count = EventoDAO::getInstance()->relCount($pub, $j);

            for ($i = 0; $i < $count; $i++) :
                $dados = EventoDAO::getInstance()->readRelatorio($pub, $i, $j);

                if ($dados === null) :
                    continue;
                endif;

                $loc = MapasDao::getInstance()->readLoc($dados->getIdMap());
                ?>
                <li>
                    <div class="collapsible-header">
                        Relatório da Quadra <?php echo $loc["quadra"]; ?> do Mapa <?php echo $loc["maps"]; ?>
                    </div>
                    <div class="collapsible-body">
                        <?php
                        if ($dados->getData1() !== null) :
                            echo "Trabalhada: " . (($dados->getDesc1() === "1") ? "Sim<br>" : "Não<br>");
                        else :
                            echo "Trabalhada: Não informado<br>";
                        endif;
                        if ($dados->getData2() !== null) :
                            echo "Número de Residências: " . $dados->getDesc2() . "<br>";
                        else :
                            echo "Número de Residências: Não informado<br>";
                        endif;
                        if ($dados->getData3() !== null) :
                            echo "Número de Comércios: " . $dados->getDesc3() . "<br>";
                        else :
                            echo "Número de Comércios: Não informado<br>";
                        endif;
                        if ($dados->getData4() !== null) :
                            echo "Número de Edifícios: " . $dados->getDesc4() . "<br>";
                        else :
                            echo "Número de Edifícios: Não informado<br>";
                        endif;

                        if ($dados->getCobert() == EventoDAO::getInstance()->cobertNow()) :
                            ?>
                            <a href="#modal-up-rel-<?php echo $i; ?>" class="btn-small blue darken-4 modal-trigger">Corrigir</a>
                            <a href="#modal-del-rel-<?php echo $i; ?>" class="btn-small red darken-4 modal-trigger">Deletar</a>
                            <?php
                        endif;
                        ?>
                    </div>

                    <?php
                    if ($dados->getCobert() == EventoDAO::getInstance()->cobertNow()) :
                        ?>
                        <!-- Modal Structure -->
                        <div id="modal-up-rel-<?php echo $i; ?>" class="modal">
                            <div class="modal-content">
                                <p>Preencha os campos abaixo para alterar o relatório</p>
                                <form action="phpaction/update_maps.php" method="POST">
                                    <input type="hidden" name="id_map" value="<?php echo $dados->getIdMap(); ?>">

                                    <input id="n_res_<?php echo $i; ?>" name="n_res_<?php echo $i; ?>" type="number" class="validate" value=<?php echo $dados->getDesc2()?> min="0">
                                    <label for="n_res_<?php echo $i; ?>">Número de Residências</label>

                                    <input id="n_com_<?php echo $i; ?>" name="n_com_<?php echo $i; ?>" type="number" class="validate" value=<?php echo $dados->getDesc3()?> min="0">
                                    <label for="n_com_<?php echo $i; ?>">Número de Comércios</label>

                                    <input id="n_edi_<?php echo $i; ?>" name="n_edi_<?php echo $i; ?>" type="number" class="validate" value=<?php echo $dados->getDesc4()?> min="0">
                                    <label for="n_edi_<?php echo $i; ?>">Número de Edifícios</label><br><br>

                                    <button type="submit" name="btn-up-rel-<?php echo $i; ?>" class="btn-small blue darken-2">Confirmar</button>
                                    <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                                </form>
                            </div>
                        </div>

                        <!-- Modal Structure -->
                        <div id="modal-del-rel-<?php echo $i; ?>" class="modal">
                            <div class="modal-content">
                                <h4>Tem certeza que deseja deletar esse relatório?</h4>
                                <p>Todas as informações fornecidas serão deletadas!</p>
                                <form action="phpaction/update_maps.php" method="POST">
                                    <input type="hidden" name="id_map" value="<?php echo $dados->getIdMap(); ?>">
                                    <button type="submit" name="btn-del-rel-<?php echo $i; ?>" class="btn-small blue darken-2">Confirmar</button>
                                    <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                                </form>
                            </div>
                        </div>
                        <?php
                    endif;
                    ?>
                </li>
                <?php
            endfor;
        endfor;
        ?>
    </ul>
    <?php
endif;
?>

<script>
$(document).ready(function() {
    $('.collapsible').collapsible({accordion: false});
})

$(document).ready(function(){
$('.modal').modal();
});
</script>

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
