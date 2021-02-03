<?php
require_once 'connect.php';

// Sessão
session_start();
?>

<?php
// Header
include_once 'includes/header.php';
// Message
include_once 'includes/message.php';
?>

        <?php
        if (!empty($erros)) :
            foreach ($erros as $erro) :
                echo $erro;
            endforeach;
        endif;
        ?>
        
        <form action="phpaction/create_dir.php" method="POST">
            Nome: <input type="text" name="nome"><br>
            Sobrenome: <input type="text" name="sobrenome"><br>
            Email: <input type="text" name="email"><br>
            Usuário: <input type="text" name="user"><br>
            Senha: <input type="password" name="senha"><br>
            Confirmar Senha: <input type="password" name="repeat-senha"><br>
            <button type="submit" name="btn-confirm">Criar Conta</button>
        </form>

        <button><a href="index.php">Cancelar</a></button>
        
<?php
// Footer
include_once 'includes/footer.php';
?>