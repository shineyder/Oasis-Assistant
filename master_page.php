<!--
Página:
    Master
Conteúdo:
    Apresenta todos os usuários cadastrados, histórico de alterações nos cadastros, histórico de relatórios emitidos e a opção de emitir a S-13. Nível de visibilidade da página será definido pelo nível de acesso do usuário
-->
<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\PublicadorDAO;

// Sessão
session_start();

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

<h4>Lista de Publicadores: </h4>

<script>
    $(document).ready(function(){
        $('select').formSelect();
    });
</script>

<?php
$action = '';
$desc = '';
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
        if ($_GET['desc'] == 'grupo') :
            $desc = "grupo";
        else :
            if ($_GET['desc'] == 'acesso') :
                $desc = "access";
            endif;
        endif;
    endif;
endif;
?>

<table>
    <tr>
        <th><a href="master_page.php?desc=<?php echo 'nome';?>&action=<?php echo $action;?>">Nome</a></th>
        <th>Sobrenome</th>
        <th>Usuário</th>
        <th>E-mail</th>
        <th><a href="master_page.php?desc=<?php echo 'grupo';?>&action=<?php echo $action;?>">Grupo</a></th>
        <th><a href="master_page.php?desc=<?php echo 'acesso';?>&action=<?php echo $action;?>">Acesso</a></th>
        <th>Definir Grupo</th>
        <th>Definir Acesso</th>
    </tr>
       
    <?php
    $countPub = PublicadorDAO::getInstance()->lastId();
    $countPub = intval($countPub['id']);

    for ($i = 1; $i <= $countPub; $i++) :
        $ini = $i - 1;
        $dadosPub = PublicadorDAO::getInstance()->readTable($desc, $action, $ini);
        echo "SELECT * FROM publicadores ORDER BY $desc $action LIMIT 1 OFFSET $ini<br>";
        ?>
        <tr>
            <td><?php echo $dadosPub->getNome(); ?></td>
            <td><?php echo $dadosPub->getSobrenome(); ?></td>
            <td><?php echo $dadosPub->getUsuario(); ?></td>
            <td><?php echo $dadosPub->getEmail(); ?></td>
            <td><?php echo $dadosPub->getGrupo(); ?></td>
            <td><?php echo $dadosPub->getAccess(); ?></td>
            <td><a href="#modal-up-gru-<?php echo $i; ?>" class="btn-small blue darken-2 modal-trigger">Definir Grupo</a></td>
            <td>
            <?php if ($publicador->getId() != $i) :?> 
                <a href="#modal-up-acc-<?php echo $i; ?>" class="btn-small blue darken-4 modal-trigger">Definir Acesso</a>
            <?php endif; ?></td>

        </tr>
        <?php
    endfor;
    ?>
</table>

<script>
$(document).ready(function() {
    $('.collapsible').collapsible({accordion: false});
})

$(document).ready(function(){
    $('.modal').modal();
});
</script>
    
<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
