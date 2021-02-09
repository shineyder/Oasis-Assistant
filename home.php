<?php
require_once 'phpaction/connect.php';

// Sessão
session_start();

//Verificação
if (!isset($_SESSION['logado'])) :
    header('Location: index.php');
endif;

//Dados
$id = $_SESSION['id_usuario'];
$sql = "SELECT * FROM dirigentes WHERE id = '$id'";
$stmt = connect::conn()->prepare($sql);
$stmt->execute();
$dados = $stmt->fetch(\PDO::FETCH_BOTH);
$stmt = connect::closeConn();

// Header
include_once 'includes/header.php';
// Message
include_once 'includes/message.php';
?>

    <b>Nome: </b> <?php echo $dados['nome'];?> <br>
    <b>Sobrenome: </b> <?php echo $dados['sobrenome'];?> <br>
    <b>Email: </b> <?php echo $dados['email'];?> <br>
    <b>Usuário: </b> <?php echo $dados['usuario'];?> <br><br>
    <a href="#modal-email" class="btn-small blue darken-4 modal-trigger">Alterar Email</a>
    <a href="#modal-senha" class="btn-small blue darken-4 modal-trigger">Alterar Senha</a>

    <!-- Modal Structure -->
    <div id="modal-email" class="modal">
        <div class="modal-content">
            <p>Preencha os campos abaixo para alterar seu email</p>
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

<?php
//Footer
include_once 'includes/footer.php';
?>
