<!--
Página:
    Problemas de login
Conteúdo:
    Sessão com opção de recuperar senha e reenviar email de autenticação. 
-->
<?php

// Sessão
session_start();

//Verificação
if (isset($_SESSION['logado'])) :
    header('Location: home.php');
    exit();
endif;

// Header
require_once 'includes/header.php';
// Message
require_once 'includes/message.php';
?>

<p><h4>Está tendo problemas para fazer login?</h4></p><br>

<form action="#" method="POST">
    <div class="input-field col s5">
        <select id="problem" name="problem">
        <option value="" disabled selected>Selecione uma opção</option>
        <option value="1">Esqueci meu usuário</option>
        <option value="2">Esqueci minha senha</option>
        <option value="3">Não recebi e-mail de autenticação</option>
        <option value="4">Outro</option>
        </select>
        <label>Selecione a opção que se enquadra com seu caso</label>
    </div>
    <button type="submit" name="btn-prox" class="btn blue darken-2">Próximo</button>
</form>

<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>
    
<form action="phpaction/recover.php" method="POST" enctype="multipart/form-data">
<?php
if (isset($_POST['btn-prox'])) {
    switch ($_POST['problem']) {
        case 1:
            ?>
            <input id="rec" name="rec" type="email" class="validate">
            <label for="rec">Digite o E-mail usado no cadastro</label>
            <input type="hidden" name="cod_err" value="<?php echo $_POST['problem']; ?>">
            <br>
            <button type="submit" name="btn-pro" class="btn blue darken-2">Enviar</button>
            <?php
            break;

        case 2:
            ?>
            <input id="rec" name="rec" type="text" class="validate">
            <label for="rec">Digite o Usuário usado no cadastro</label>
            <input id="rec2" name="rec2" type="email" class="validate">
            <label for="rec2">Digite o E-mail usado no cadastro</label>
            <input type="hidden" name="cod_err" value="<?php echo $_POST['problem']; ?>">
            <br>
            <button type="submit" name="btn-pro" class="btn blue darken-2">Enviar</button>
            <?php
            break;

        case 3:
            ?>
            <input id="rec" name="rec" type="text" class="validate">
            <label for="rec">Digite o Usuário usado no cadastro</label>
            <input id="rec2" name="rec2" type="email" class="validate">
            <label for="rec2">Digite o E-mail usado no cadastro</label>
            <input type="hidden" name="cod_err" value="<?php echo $_POST['problem']; ?>">
            <br>
            <button type="submit" name="btn-pro" class="btn blue darken-2">Enviar</button>
            <?php
            break;

        case 4:
            ?>
            <br>
            <textarea id="rec" name="rec"></textarea>
            <label for="rec">Explique qual problema está tendo</label>
            <input id="rec2" name="rec2" type="text" class="validate">
            <label for="rec2">Digite o Usuário ou E-mail usado no cadastro</label>
            <div class="btn-file">
                <br><span>Arquivo limitado a 1Mb (.png ou .jpeg)</span>
                <input type="file" id="fileToUpload" name="fileToUpload" accept="image/png, image/jpeg">
                <br><label for="fileToUpload">Envie uma foto do problema</label>
            </div>
            <br>
            <button type="submit" name="btn-pro-plus" class="btn blue darken-2">Enviar</button>
            <?php
            break;
    }
}
?>
</form>

<script>
    $('#rec').val('');
    M.textareaAutoResize($('#rec'));
</script>

<?php
//Footer
require_once 'includes/footer.php';
?>