<?php
require_once 'connect.php';

// Sessão
session_start();

if (isset($_POST['btn-entrar'])) :
    $erros = array();
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) or empty($senha)) :
        $_SESSION['mensagem'] = "Os campos Login e Senha precisam ser preenchidos";
    else :
        $sql = "SELECT usuario FROM dirigentes WHERE usuario = '$login'";
        $stmt = connect::conn()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 1) :
            $senha = md5($senha);
            $sql = "SELECT * FROM dirigentes WHERE usuario = '$login' AND senha = '$senha'";
            $stmt = connect::conn()->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() == 1) :
                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
                $stmt = connect::closeConn();
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                header('Location: home.php');
            else :
                $_SESSION['mensagem'] = "Usuário e senha não conferem";
            endif;
        else :
            $_SESSION['mensagem'] = "Usuário inexistente";
        endif;
    endif;
endif;

// Header
include_once 'includes/header.php';
// Message
include_once 'includes/message.php';
?>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            Login: <input type="text" name="login"><br>
            Senha: <input type="password" name="senha"><br>
            <button type="submit" name="btn-entrar">Entrar</button>
        </form>

        <button><a href="signup.php">Criar conta</a></button>
        <a href="recovery.php">Recuperar senha</a>
<?php
//Footer
include_once 'includes/footer.php';
?>
