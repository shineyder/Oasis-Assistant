<?php
session_start();
?>
<!--
Página:
    Autenticação
Conteúdo:
    Sessão de autenticação de email.
Detalhes:
    Usuários sem email autenticado tem permissão de acesso nível 0 e não conseguem logar, ao autenticar o email o nivel de acesso se torna 1. 
-->

<?php
// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\PublicadorDAO;

//Verificação
if (!isset($_GET['cd'])) :
    redirect('https://oasisassistant.000webhostapp.com/');
    exit();
endif;
$is_ok = 0;

//Dados
$dados_last = PublicadorDAO::getInstance()->lastId();

for ($i = 1; $i <= $dados_last['id']; $i++) {
    $PublicadorDAO = PublicadorDAO::getInstance()->read(['id' , 'access'], [$i, 0], 'usuario');
    $dadostemp = $PublicadorDAO->fetch(\PDO::FETCH_BOTH);

    if ($dadostemp != false) {
        if ($_GET['cd'] == md5($dadostemp['usuario'])) {
            $is_ok = 1;
            $publicador = PublicadorDAO::getInstance()->readAll(['id', ""], [$i, ""]);
            $publicador->setAccess(1);
            $PublicadorDAO = PublicadorDAO::getInstance()->update($publicador);
            break;
        }
    }
}

// Header
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
// Message
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/message.php';

if ($is_ok == 1) :
    ?>
    <div class="center">
        <h4>Autenticação concluida com sucesso!</h4>
        <p>Seu email foi autenticado e seu acesso ao Oasis Assistant foi liberado.</p>
        <a href="index.php" class="btn blue darken-2">Fazer LogIn</a>
    </div>
    <?php
else :
    ?>
    <div class="center">
        <h4>Houve algum erro com a autenticação!</h4>
        <p>Link de verificação utilizado inválido.</p>
        <a href="index.php" class="btn blue darken-2">Página Inicial</a>
    </div>
    <?php
endif;

//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
