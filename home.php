<?php

session_start();

/** Página:
*     Home
*   Conteúdo:
*     Dados do Usuário, opções de trocar email e senha.*/

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Verificação
if (!isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/');
    exit();
endif;

//Dados
$publicador = unserialize($_SESSION['obj']);

// Header
require_once 'includes/header.php';
// Message
require_once 'includes/message.php';
?>

<!-- ABERTURA DAS ESTRUTURAS DE CONTEUDO-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Meu Perfil</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Meu Perfil</a></li>
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
if ($publicador->getAccess() == 1) :
    ?>
    <p>Sua conta aguarda análise dos administradores, após a análise sua conta terá o acesso as funcionalidades liberado.</p>
    <?php
endif;
?>

<b>Nome: </b><?php echo $publicador->getNome();?> <br>
<b>Sobrenome: </b><?php echo $publicador->getSobrenome();?> <br>
<b>E-mail: </b><?php echo $publicador->getEmail();?> <br>
<b>Grupo: </b><?php echo (($publicador->getGrupo() == null) ? "à definir" : $publicador->getGrupo());?>
<br>
<b>Usuário: </b> <?php echo $publicador->getUsuario();?><br><br>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-email">
    Alterar E-mail
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-senha">
    Alterar Senha
</button>

<!-- modal -->
<div class="modal fade" id="modal-email">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Alterar E-mail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Preencha os campos abaixo para alterar seu e-mail</p>
                <form action="phpaction/update_pub.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $publicador->getId(); ?>">
                    <input id="email-up" name="email-up" type="email" class="validate">
                    <label for="email-up">Novo Email</label><br><br>
                    <button type="submit" name="btn-up-email" class="btn btn-primary">Confirmar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Structure -->
<div id="asmodal-email" class="modal">
    <div class="modal-content">
        <p>Preencha os campos abaixo para alterar seu e-mail</p>
        <form action="phpaction/update_pub.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $publicador->getId(); ?>">
            <input id="email-up" name="email-up" type="email" class="validate">
            <label for="email-up">Novo Email</label><br><br>
            <button type="submit" name="btn-up-email" class="btn-small blue darken-2">Confirmar</button>
            <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
        </form>
    </div>
</div>

<!-- Modal Structure -->
<div id="modal-senha" class="modal">
    <div class="modal-content">
        <p>Preencha os campos abaixo para alterar sua senha</p>
        <form action="phpaction/update_pub.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $publicador->getId(); ?>">
            <input id="senha-old" name="senha-old" type="password" class="validate">
            <label for="senha-old">Senha Antiga</label><br>
            <input id="senha-up" name="senha-up" type="password" class="validate">
            <label for="senha-up">Nova Senha</label><br>
            <input id="senha-up-conf" name="senha-up-conf" type="password" class="validate">
            <label for="senha-up-conf">Confirmar Nova Senha</label><br><br>
            <button type="submit" name="btn-up-senha" class="btn-small blue darken-2">Confirmar</button>
            <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
        </form>
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

<script>
    $(document).ready(function(){
        $('.modal').modal();
        });
</script>

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
