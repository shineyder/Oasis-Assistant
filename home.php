<!--
Página:
    Home
Conteúdo:
    Dados do Usuário, opções de trocar email e senha. 
-->

<?php
require_once 'phpaction/connect.php';

// Sessão
session_start();

//Verificação
if (!isset($_SESSION['logado'])) :
    header('Location: index.php');
    exit();
endif;

//Dados
$id = $_SESSION['id_usuario'];
$sql = "SELECT * FROM dirigentes WHERE id = '$id'";
$stmt = conectar\Connect::conn()->prepare($sql);
$stmt->execute();
$dados = $stmt->fetch(\PDO::FETCH_BOTH);
$stmt = conectar\Connect::closeConn();

// Header
require_once 'includes/header.php';
// Message
require_once 'includes/message.php';
?>

    <b>Nome: </b> <?php echo $dados['nome'];?> <br>
    <b>Sobrenome: </b> <?php echo $dados['sobrenome'];?> <br>
    <b>E-mail: </b> <?php echo $dados['email'];?> <br>
    <b>Usuário: </b> <?php echo $dados['usuario'];?> <br><br>
    <a href="#modal-email" class="btn-small blue darken-4 modal-trigger">Alterar E-mail</a>
    <a href="#modal-senha" class="btn-small blue darken-4 modal-trigger">Alterar Senha</a>

    <!-- Modal Structure -->
    <div id="modal-email" class="modal">
        <div class="modal-content">
            <p>Preencha os campos abaixo para alterar seu e-mail</p>
            <form action="phpaction/update_dir.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
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
            <form action="phpaction/update_dir.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
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
require_once 'includes/footer.php';
?>
