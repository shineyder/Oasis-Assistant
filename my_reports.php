<?php

session_start();

/** Página:
*     Meus Relatórios
*   Conteúdo:
*     Apresenta todos os relatórios feitos pelo usuário e permite alterar ou deletar relatórios feitos nas últimas 24hrs.*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\PublishersDAO;
use Assistant\EventsDAO;
use Assistant\MapsDAO;

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

<!-- ABERTURA DAS ESTRUTURAS DE CONTEUDO-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Relatórios</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active">Relatórios</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
<!-- /.ABERTURA DAS ESTRUTURAS DE CONTEUDO-->

<?php
if ($publicador->getAccess() >= 8) :
    $totId = PublishersDAO::getInstance()->lastId();
    $totId = intval($totId['id']);
    ?>
    <h5>Emitir S-13:</h5>
    <a target="_blank" href="http://oasisassistant.com/phpaction/doS13.php" class="btn btn-primary">S-13</a>
    <br><br>
    <form action="#" method="POST">
        <!-- select -->
        <div class="form-group">
            <label>Ver relatórios de:</label>
            <select id="publicador" name="publicador" class="form-control">
                <option value="" disabled selected>Selecione uma opção</option>
                <?php
                for ($i = 1; $i <= $totId; $i++) :
                    $nome = PublishersDAO::getInstance()->read('id', $i, 'nome, sobrenome')->fetch(\PDO::FETCH_BOTH);
                    ?>
                    <option value="<?php echo $i; ?>"><?php echo $nome["nome"] . " " . $nome["sobrenome"];?></option>
                    <?php
                endfor;
                ?>
            </select>
        </div>
        <button type="submit" name="btn-pub" class="btn btn-primary">Próximo</button>
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

    <h2>Relatórios feitos:</h2>

    <?php
    $cob = EventsDAO::getInstance()->cobertNow();
    for ($j = 1; $j <= $cob; $j++) :
        $count = EventsDAO::getInstance()->relCount($pub, $j);
        for ($i = 0; $i < $count; $i++) :
            $dados = EventsDAO::getInstance()->readRelatorio($pub, $i, $j);
            if ($dados === null) :
                continue;
            endif;
            $loc = MapsDAO::getInstance()->readLoc($dados->getIdMap());
            ?>
            <!-- Default box -->
            <div class="card collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Relatório da Quadra <?php echo $loc["quadra"]; ?> do Mapa <?php echo $loc["maps"]; ?></h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Colapsar"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body">
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

                    if ($dados->getCobert() == EventsDAO::getInstance()->cobertNow()) :
                        ?>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-rel-<?php echo $i; ?>">Corrigir</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-del-rel-<?php echo $i; ?>">Deletar</button>
                        <?php
                    endif;
                    ?>
                </div>
                <!-- /.card-body -->
                <?php
                if ($dados->getCobert() == EventsDAO::getInstance()->cobertNow()) :
                    ?>
                    <div class="modal fade" id="modal-up-rel-<?php echo $i; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Corrigir Relatório</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Preencha os campos abaixo para alterar o relatório</p>
                                    <form action="phpaction/update_maps.php" method="POST">
                                        <input type="hidden" name="id_map" value="<?php echo $dados->getIdMap(); ?>">
                                        
                                        <div class="input-group mb-3">
                                            <input id="n_res_<?php echo $i; ?>" name="n_res_<?php echo $i; ?>" type="number" class="form-control" placeholder="Número de Residências">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-home"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="n_com_<?php echo $i; ?>" name="n_com_<?php echo $i; ?>" type="number" class="form-control" placeholder="Número de Comércios">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-store"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input id="n_edi_<?php echo $i; ?>" name="n_edi_<?php echo $i; ?>" type="number" class="form-control" placeholder="Número de Edifícios">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-building"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" name="btn-up-rel-<?php echo $i; ?>" class="btn btn-primary">Confirmar</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->

                    <!-- modal -->
                    <div class="modal fade" id="modal-del-rel-<?php echo $i; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Deletar Relatório</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h5>Tem certeza que deseja deletar esse relatório?</h5>
                                    <p>Todas as informações fornecidas serão deletadas!</p>
                                    <form action="phpaction/update_maps.php" method="POST">
                                        <input type="hidden" name="id_map" value="<?php echo $dados->getIdMap(); ?>">
                                        <button type="submit" name="btn-del-rel-<?php echo $i; ?>" class="btn btn-warning">Confirmar</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->
                    <?php
                endif;
                ?>
            </div>
            <!-- /.card -->
            <?php
        endfor;
    endfor;
endif;
?>

<!-- FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
<!-- /.FECHAMENTO DAS ESTRUTURAS DE CONTEUDO-->

<script type="text/javascript">
    $(document).ready(function() {
        $('.collapsible').collapsible({accordion: false});
    })

    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
