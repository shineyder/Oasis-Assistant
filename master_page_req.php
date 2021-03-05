<?php

session_start();

/** Página:
*     Master - Requests (Solicitações)
*   Conteúdo:
*     Apresenta todos as solicitações em aberto. Nível de visibilidade da página será definido pelo nível de acesso do usuário*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\ContactUsDAO;
use Assistant\PublishersDAO;

//Verificação
if (!isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/');
    exit();
endif;

//Dados
$publicador = unserialize($_SESSION['obj']);

//Verificação de nível de acesso
if ($publicador->getAccess() < 8) :
    redirect('http://oasisassistant.com/home.php');
    exit();
endif;

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
                        <h1>Soliticações</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active">Solicitações</a></li>
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

<h5>Lista Solicitações do Fale Conosco: </h5>
<h6>Problemas encontrados:</h6>

<?php
$countSol = ContactUsDAO::getInstance()->solCount("Problema");
if ($countSol == 0) :
    echo "<p>Nenhuma solicitação em aberto com assunto Problema.</p>";
else :
    ?>
    <table style="width: 98%; word-wrap: break-word; table-layout: fixed;">
        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>E-mail</th>
            <th>Solicitação</th>
            <th>Data</th>
            <th>Ticket</th>
            <th>Status</th>
            <th>Definir Status</th>
        </tr>

        <?php
        $countSol = ContactUsDAO::getInstance()->solCount("Problema");

        for ($i = 1; $i <= $countSol; $i++) :
            $ini = $i - 1;
            $dadosSol = ContactUsDAO::getInstance()->read("Problema", $ini);
            $dadosPub = PublishersDAO::getInstance()->read('id', $dadosSol->getIdUser(), 'nome, sobrenome, email')->fetch(\PDO::FETCH_BOTH);
            ?>
            <tr>
                <td><?php echo $dadosPub['nome']; ?></td>
                <td><?php echo $dadosPub['sobrenome']; ?></td>
                <td><?php echo $dadosPub['email']; ?></td>
                <td><?php echo $dadosSol->getMensag(); ?></td>
                <td><?php echo $dadosSol->getTimeN(); ?></td>
                <td><?php echo $dadosSol->getTicket(); ?></td>
                <td><?php echo $dadosSol->getStatus(); ?></td>
                <td><a href="#modal-up-sol-pro-<?php echo $i; ?>" class="btn-small blue darken-2 modal-trigger">Definir</a></td>
                <td>
            </tr>

            <!-- Modal Structure -->
            <div id="modal-up-sol-pro-<?php echo $dadosSol->getId(); ?>" class="modal">
                <div class="modal-content">
                    <p>Defina o status da solicitação</p>
                    <form action="phpaction/update_req.php" method="POST">
                        <p><label>
                            <input name="sol-pro-<?php echo $i; ?>" type="radio" value="em Espera" checked/>
                            <span>em Espera</span>
                        </label></p>
                        <p><label>
                            <input name="sol-pro-<?php echo $i; ?>" type="radio" value="em Analise"/>
                            <span>em Analise</span>
                        </label></p>
                        <p><label>
                            <input name="sol-pro-<?php echo $i; ?>" type="radio" value="Concluido"/>
                            <span>Concluido</span>
                        </label></p>
                        <button type="submit" name="btn-up-sol-pro-<?php echo $i; ?>" class="btn-small blue darken-2">Confirmar</button>
                        <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                    </form>
                </div>
            </div>
            <?php
        endfor;
        ?>
    </table>
    <?php
endif;
?>

<h6>Sugestões feitas:</h6>

<?php
$countSol = ContactUsDAO::getInstance()->solCount("Sugestão");
if ($countSol == 0) :
    echo "<p>Nenhuma solicitação em aberto com assunto Sugestão.</p>";
else :
    ?>
    <table style="width: 98%; word-wrap: break-word; table-layout: fixed;">
        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>E-mail</th>
            <th>Solicitação</th>
            <th>Data</th>
            <th>Ticket</th>
            <th>Status</th>
            <th>Definir Status</th>
        </tr>

        <?php
        for ($i = 1; $i <= $countSol; $i++) :
            $ini = $i - 1;
            $dadosSol = ContactUsDAO::getInstance()->read("Sugestão", $ini);
            $dadosPub = PublishersDAO::getInstance()->read('id', $dadosSol->getIdUser(), 'nome, sobrenome, email')->fetch(\PDO::FETCH_BOTH);
            ?>
            <tr>
                <td><?php echo $dadosPub['nome']; ?></td>
                <td><?php echo $dadosPub['sobrenome']; ?></td>
                <td><?php echo $dadosPub['email']; ?></td>
                <td><?php echo $dadosSol->getMensag(); ?></td>
                <td><?php echo $dadosSol->getTimeN(); ?></td>
                <td><?php echo $dadosSol->getTicket(); ?></td>
                <td><?php echo $dadosSol->getStatus(); ?></td>
                <td><a href="#modal-up-sol-sug-<?php echo $i; ?>" class="btn-small blue darken-2 modal-trigger">Definir</a></td>
                <td>
            </tr>

            <!-- Modal Structure -->
            <div id="modal-up-sol-sug-<?php echo $i; ?>" class="modal">
                <div class="modal-content">
                    <p>Defina o status da solicitação</p>
                    <form action="phpaction/update_req.php" method="POST">
                        <p><label>
                            <input name="sol-sug-<?php echo $i; ?>" type="radio" value="em Espera" checked/>
                            <span>em Espera</span>
                        </label></p>
                        <p><label>
                            <input name="sol-sug-<?php echo $i; ?>" type="radio" value="em Analise"/>
                            <span>em Analise</span>
                        </label></p>
                        <p><label>
                            <input name="sol-sug-<?php echo $i; ?>" type="radio" value="Concluido"/>
                            <span>Concluido</span>
                        </label></p>
                        <button type="submit" name="btn-up-sol-sug-<?php echo $i; ?>" class="btn-small blue darken-2">Confirmar</button>
                        <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                    </form>
                </div>
            </div>
            <?php
        endfor;
        ?>
    </table>
    <?php
endif;
?>

<h6>Outros:</h6>

<?php
$countSol = ContactUsDAO::getInstance()->solCount("Outro");
if ($countSol == 0) :
    echo "<p>Nenhuma solicitação em aberto com assunto Outro.</p>";
else :
    ?>
    <table style="width: 98%; word-wrap: break-word; table-layout: fixed;">
        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>E-mail</th>
            <th>Solicitação</th>
            <th>Data</th>
            <th>Ticket</th>
            <th>Status</th>
            <th>Definir Status</th>
        </tr>

        <?php
        for ($i = 1; $i <= $countSol; $i++) :
            $ini = $i - 1;
            $dadosSol = ContactUsDAO::getInstance()->read("Outro", $ini);
            $dadosPub = PublishersDAO::getInstance()->read('id', $dadosSol->getIdUser(), 'nome, sobrenome, email')->fetch(\PDO::FETCH_BOTH);
            ?>
            <tr>
                <td><?php echo $dadosPub['nome']; ?></td>
                <td><?php echo $dadosPub['sobrenome']; ?></td>
                <td><?php echo $dadosPub['email']; ?></td>
                <td><?php echo $dadosSol->getMensag(); ?></td>
                <td><?php echo $dadosSol->getTimeN(); ?></td>
                <td><?php echo $dadosSol->getTicket(); ?></td>
                <td><?php echo $dadosSol->getStatus(); ?></td>
                <td><a href="#modal-up-sol-out-<?php echo $i; ?>" class="btn-small blue darken-2 modal-trigger">Definir</a></td>
                <td>
            </tr>

            <!-- Modal Structure -->
            <div id="modal-up-sol-out-<?php echo $i; ?>" class="modal">
                <div class="modal-content">
                    <p>Defina o status da solicitação</p>
                    <form action="phpaction/update_req.php" method="POST">
                        <p><label>
                            <input name="sol-out-<?php echo $i; ?>" type="radio" value="em Espera" checked/>
                            <span>em Espera</span>
                        </label></p>
                        <p><label>
                            <input name="sol-out-<?php echo $i; ?>" type="radio" value="em Analise"/>
                            <span>em Analise</span>
                        </label></p>
                        <p><label>
                            <input name="sol-out-<?php echo $i; ?>" type="radio" value="Concluido"/>
                            <span>Concluido</span>
                        </label></p>
                        <button type="submit" name="btn-up-sol-out-<?php echo $i; ?>" class="btn-small blue darken-2">Confirmar</button>
                        <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                    </form>
                </div>
            </div>
            <?php
        endfor;
        ?>
    </table>
    <?php
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
    
<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
