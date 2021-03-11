<?php

session_start();

/** Página:
*     Master - Reports (relatórios)
*   Conteúdo:
*     Apresenta todos os usuários cadastrados, histórico de alterações nos cadastros, histórico de relatórios emitidos e a opção de emitir a S-13. Nível de visibilidade da página será definido pelo nível de acesso do usuário*/

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

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
                        <h1>Publicadores</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                            <li class="breadcrumb-item active">Publicadores</a></li>
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
$action = 'ASC';
$desc = 'id';
if (isset($_GET["desc"])) :
    $desc = $_GET["desc"];
    $action = $_GET["action"];

    if ($action == 'ASC') :
        $action = 'DESC';
    else :
        $action = 'ASC';
    endif;

    if ($_GET['desc'] == 'nome') :
        $desc = "nome";
    else :
        if ($_GET['desc'] == 'sobrenome') :
            $desc = "sobrenome";
        else :
            if ($_GET['desc'] == 'grupo') :
                $desc = "grupo";
            else :
                if ($_GET['desc'] == 'acesso') :
                    $desc = "access";
                endif;
            endif;
        endif;
    endif;
endif;
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de Publicadores:</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th><a href="master_page_pub.php?desc=<?php echo 'nome';?>&action=<?php echo $action;?>">Nome</a></th>
                            <th><a href="master_page_pub.php?desc=<?php echo 'sobrenome';?>&action=<?php echo $action;?>">Sobrenome</a></th>
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th><a href="master_page_pub.php?desc=<?php echo 'grupo';?>&action=<?php echo $action;?>">Grupo</a></th>
                            <th><a href="master_page_pub.php?desc=<?php echo 'acesso';?>&action=<?php echo $action;?>">Acesso</a></th>
                            <th>Definir Grupo</th>
                            <th>Definir Acesso</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $countPub = PublishersDAO::getInstance()->lastId();
                    $countPub = intval($countPub['id']);

                    for ($i = 1; $i <= $countPub; $i++) :
                        $ini = $i - 1;
                        $dadosPub = PublishersDAO::getInstance()->readTable($desc, $action, $ini);
                        ?>
                        <tr>
                            <td><?php echo $dadosPub->getNome();?></td>
                            <td><?php echo $dadosPub->getSobrenome();?></td>
                            <td><?php echo $dadosPub->getUsuario();?></td>
                            <td><?php echo $dadosPub->getEmail();?></td>
                            <td><?php echo $dadosPub->getGrupo();?></td>
                            <td><?php echo $dadosPub->getAccess();?></td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-gru-<?php echo $dadosPub->getId();?>">Definir</button>
                            </td>
                            <td>
                                <?php if ($publicador->getId() != $dadosPub->getId()) :?> 
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-up-acc-<?php echo $dadosPub->getId();?>">Definir</button>
                                <?php endif;?>
                            </td>
                        </tr>

                        <!-- modal -->
                        <div class="modal fade" id="modal-up-gru-<?php echo $dadosPub->getId();?>" style="height: 400px;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Grupo</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Selecione o Grupo ao qual o publicador pertence</p>
                                        <form action="phpaction/update_pub.php" method="POST">
                                            <input type="hidden" name="id" value="<?php echo $publicador->getId();?>">
                                            <!-- radio -->
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group-<?php echo $dadosPub->getId();?>" id="group1-<?php echo $dadosPub->getId();?>" value="Porto Novo 1">
                                                    <label for="group1-<?php echo $dadosPub->getId();?>" class="custom-control-label">Porto Novo 1</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group-<?php echo $dadosPub->getId();?>" id="group2-<?php echo $dadosPub->getId();?>" value="Porto Novo 2">
                                                    <label for="group2-<?php echo $dadosPub->getId();?>" class="custom-control-label">Porto Novo 2</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group-<?php echo $dadosPub->getId();?>" id="group3-<?php echo $dadosPub->getId();?>" value="Presidente Médici">
                                                    <label for="group3-<?php echo $dadosPub->getId();?>" class="custom-control-label">Presidente Médici</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group-<?php echo $dadosPub->getId();?>" id="group4-<?php echo $dadosPub->getId();?>" value="Morro do Sesi">
                                                    <label for="group4-<?php echo $dadosPub->getId();?>" class="custom-control-label">Morro do Sesi</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="group-<?php echo $dadosPub->getId();?>" id="group5-<?php echo $dadosPub->getId();?>" value="Del Porto">
                                                    <label for="group5-<?php echo $dadosPub->getId();?>" class="custom-control-label">Del Porto</label>
                                                </div>
                                            </div>
                                            <button type="submit" name="btn-up-gru-<?php echo $dadosPub->getId();?>" class="btn btn-primary">Confirmar</button>
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
                        <div class="modal fade" id="modal-up-acc-<?php echo $dadosPub->getId();?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Nível de Acesso</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Defina o nível de acesso do publicador</p>
                                        <form action="phpaction/update_pub.php" method="POST">
                                            <!-- radio -->
                                            <div class="form-group">
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc1-<?php echo $dadosPub->getId();?>" value="-1">
                                                    <label for="acc1-<?php echo $dadosPub->getId();?>" class="custom-control-label">Desassociado</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc2-<?php echo $dadosPub->getId();?>" value="1">
                                                    <label for="acc2-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 1</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc3-<?php echo $dadosPub->getId();?>" value="2">
                                                    <label for="acc3-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 2</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc4-<?php echo $dadosPub->getId();?>" value="3">
                                                    <label for="acc4-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 3</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc5-<?php echo $dadosPub->getId();?>" value="4">
                                                    <label for="acc5-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 4</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc6-<?php echo $dadosPub->getId();?>" value="5">
                                                    <label for="acc6-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 5</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc7-<?php echo $dadosPub->getId();?>" value="6">
                                                    <label for="acc7-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 6</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc8-<?php echo $dadosPub->getId();?>" value="7">
                                                    <label for="acc8-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 7</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc9-<?php echo $dadosPub->getId();?>" value="8">
                                                    <label for="acc9-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 8</label>
                                                </div>
                                                <?php
                                                if ($publicador->getAccess() == 10) :
                                                    ?>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" name="acc-<?php echo $dadosPub->getId();?>" id="acc10-<?php echo $dadosPub->getId();?>" value="9">
                                                        <label for="acc10-<?php echo $dadosPub->getId();?>" class="custom-control-label">Publicador nv 9</label>
                                                    </div>
                                                    <?php
                                                endif;
                                                ?>
                                            </div>
                                            <button type="submit" name="btn-up-acc-<?php echo $dadosPub->getId();?>" class="btn btn-primary">Confirmar</button>
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
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Grupo</th>
                            <th>Acesso</th>
                            <th>Definir Grupo</th>
                            <th>Definir Acesso</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

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
