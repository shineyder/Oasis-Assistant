<!DOCTYPE html>
<?php
require_once 'connect.php';

//Sessão
session_start();

if (isset($_POST['btn-entrar'])) :
    $erros = array();
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    if (empty($login) or empty($senha)) :
        $erros[] = "<li>Os campos Login e Senha precisam ser preenchidos</li>";
    else :
        $sql = "SELECT login FROM dirigentes WHERE login = '$login'";
        $stmt = connect::conn()->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) :
            $senha = md5($senha);
            $sql = "SELECT * FROM dirigentes WHERE login = '$login' AND senha = '$senha'";
            $stmt = connect::conn()->prepare($sql);
            $stmt->execute();

            if ($stmt->rowCount() == 1) :
                $dados = $stmt->fetch(\PDO::FETCH_ASSOC);
                $stmt = connect::closeConn();
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                header('Location: home.php');
            else :
                $erros[] = "<li>Usuário e senha não conferem</li>";
            endif;
        else :
            $erros[] = "<li> Usuário inexistente</li>";
        endif;
    endif;
endif;
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Maps Assistant</title>
    </head>
    <body>
        <?php
        if (!empty($erros)) :
            foreach ($erros as $erro) :
                echo $erro;
            endforeach;
        endif;
        ?>
        
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
            Login: <input type="text" name="login"><br>
            Senha: <input type="password" name="senha"><br>
            <button type="submit" name="btn-entrar">Entrar</button>
        </form>
    </body>
</html>
