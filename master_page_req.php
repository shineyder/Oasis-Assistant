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

<?php
$countSol = ContactUsDAO::getInstance()->solCount("Problema");
if ($countSol == 0) :
    echo "<p>Nenhuma solicitação em aberto com assunto Problema.</p>";
else :
    ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Problemas encontrados: </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
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
                </thead>
                <tbody>
                    <?php
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
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-sol-pro-<?php echo $i; ?>">Definir</button>
                            </td>
                        </tr>

                        <!-- modal -->
                        <div class="modal fade" id="modal-up-sol-pro-<?php echo $i; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Status</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Defina o status da solicitação</p>
                                        <form action="phpaction/update_req.php" method="POST">
                                            <!-- radio -->
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-pro-<?php echo $i; ?>" id="sol-pro1-<?php echo $i; ?>" value="em Espera">
                                                    <label for="sol-pro1-<?php echo $i; ?>" class="custom-control-label">em Espera</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-pro-<?php echo $i; ?>" id="sol-pro2-<?php echo $i; ?>" value="em Analise">
                                                    <label for="sol-pro2-<?php echo $i; ?>" class="custom-control-label">em Analise</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-pro-<?php echo $i; ?>" id="sol-pro3-<?php echo $i; ?>" value="Concluido">
                                                    <label for="sol-pro3-<?php echo $i; ?>" class="custom-control-label">Concluido</label>
                                                </div>
                                            </div>
                                            <button type="submit" name="btn-up-sol-pro-<?php echo $i; ?>" class="btn btn-primary">Confirmar</button>
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
                    endfor;
                    ?>
                </tbody>
                <tfoot>
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
                </tfoot>
            </table>
        </div>
    </div>
    <?php
endif;
?>

<?php
$countSol = ContactUsDAO::getInstance()->solCount("Sugestão");
if ($countSol == 0) :
    echo "<p>Nenhuma solicitação em aberto com assunto Sugestão.</p>";
else :
    ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Sugestões feitas: </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
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
                </thead>
                <tbody>
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
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-sol-sug-<?php echo $i; ?>">Definir</button>
                            </td>
                        </tr>

                        <!-- modal -->
                        <div class="modal fade" id="modal-up-sol-sug-<?php echo $i; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Status</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Defina o status da solicitação</p>
                                        <form action="phpaction/update_req.php" method="POST">
                                            <!-- radio -->
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-sug-<?php echo $i; ?>" id="sol-sug1-<?php echo $i; ?>" value="em Espera">
                                                    <label for="sol-sug1-<?php echo $i; ?>" class="custom-control-label">em Espera</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-sug-<?php echo $i; ?>" id="sol-sug2-<?php echo $i; ?>" value="em Analise">
                                                    <label for="sol-sug2-<?php echo $i; ?>" class="custom-control-label">em Analise</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-sug-<?php echo $i; ?>" id="sol-sug3-<?php echo $i; ?>" value="Concluido">
                                                    <label for="sol-sug3-<?php echo $i; ?>" class="custom-control-label">Concluido</label>
                                                </div>
                                            </div>
                                            <button type="submit" name="btn-up-sol-sug-<?php echo $i; ?>"  class="btn btn-primary">Confirmar</button>
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
                    endfor;
                    ?>
                </tbody>
                <tfoot>
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
                </tfoot>
            </table>
        </div>
    </div>
    <?php
endif;
?>

<?php
$countSol = ContactUsDAO::getInstance()->solCount("Outro");
if ($countSol == 0) :
    echo "<p>Nenhuma solicitação em aberto com assunto Outro.</p>";
else :
    ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Outros: </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
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
                </thead>
                <tbody>
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
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-sol-out-<?php echo $i; ?>">Definir</button>
                            </td>
                        </tr>

                        <!-- modal -->
                        <div class="modal fade" id="modal-up-sol-out-<?php echo $i; ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Status</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Defina o status da solicitação</p>
                                        <form action="phpaction/update_req.php" method="POST">
                                            <!-- radio -->
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-out-<?php echo $i; ?>" id="sol-out1-<?php echo $i; ?>" value="em Espera">
                                                    <label for="sol-out1-<?php echo $i; ?>" class="custom-control-label">em Espera</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-out-<?php echo $i; ?>" id="sol-out2-<?php echo $i; ?>" value="em Analise">
                                                    <label for="sol-out2-<?php echo $i; ?>" class="custom-control-label">em Analise</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="sol-out-<?php echo $i; ?>" id="sol-out3-<?php echo $i; ?>" value="Concluido">
                                                    <label for="sol-out3-<?php echo $i; ?>" class="custom-control-label">Concluido</label>
                                                </div>
                                            </div>
                                            <button type="submit" name="btn-up-sol-out-<?php echo $i; ?>"  class="btn btn-primary">Confirmar</button>
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
                    endfor;
                    ?>
                </tbody>
                <tfoot>
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
                </tfoot>
            </table>
        </div>
    </div>
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

<!-- page script -->
<script>
    $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
  });
</script>

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
