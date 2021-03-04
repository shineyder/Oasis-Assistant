<?php
session_start();
?>
<!--
Página:
    Home
Conteúdo:
    Dados do Usuário, opções de trocar email e senha. 
-->

<?php
// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Verificação
if (!isset($_SESSION['logado'])) :
    redirect('https://oasisassistant.000webhostapp.com/');
    exit();
endif;

//Dados
$publicador = unserialize($_SESSION['obj']);

// Header
require_once 'includes/header.php';
// Message
require_once 'includes/message.php';

    if ($publicador->getAccess() == 1) :
        ?>
        <p>Sua conta aguarda análise dos administradores, após a análise sua conta terá o acesso as funcionalidades liberado.</p>
        <?php
    endif;
    ?>

    <b>Nome: </b> <?php echo $publicador->getNome();?> <br>
    <b>Sobrenome: </b> <?php echo $publicador->getSobrenome();?> <br>
    <b>E-mail: </b> <?php echo $publicador->getEmail();?> <br>
    <b>Grupo: </b> <?php echo (($publicador->getGrupo() == null) ? "à definir" : $publicador->getGrupo());?> <br>
    <b>Usuário: </b> <?php echo $publicador->getUsuario();?> <br><br>
    <a href="#modal-email" class="btn-small blue darken-4 modal-trigger">Alterar E-mail</a>
    <a href="#modal-senha" class="btn-small blue darken-4 modal-trigger">Alterar Senha</a>
    
    <!-- Modal Structure -->
    <div id="modal-email" class="modal">
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

    <script>
        $(document).ready(function(){
            $('.modal').modal();
            });
    </script>

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
