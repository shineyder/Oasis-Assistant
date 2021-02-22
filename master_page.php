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

<h5>Emitir S-13:</h5>
<a target="_blank" href="http://oasisassistant.com/phpaction/doS13.php" class="btn-small blue darken-4">S-13</a><br>
<h5>Lista de Publicadores: </h5>

<?php
$action = 'ASC';
$desc = 'id';
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
        if ($_GET['desc'] == 'sobrenome') :
            $desc = "sobrenome";
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
endif;
?>

<table>
    <tr>
        <th><a href="master_page.php?desc=<?php echo 'nome';?>&action=<?php echo $action;?>">Nome</a></th>
        <th><a href="master_page.php?desc=<?php echo 'sobrenome';?>&action=<?php echo $action;?>">Sobrenome</a></th>
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

        <!-- Modal Structure -->
        <div id="modal-up-gru-<?php echo $dadosPub->getId(); ?>" class="modal" style="height: 400px;">
            <div class="modal-content">
                <p>Selecione o Grupo ao qual o publicador pertence</p>
                <form action="phpaction/update_pub.php" method="POST">
                    <p><label>
                        <input name="group-<?php echo $dadosPub->getId(); ?>" type="radio" value="Porto Novo 1" checked />
                        <span>Porto Novo 1</span>
                    </label></p>
                    <p><label>
                        <input name="group-<?php echo $dadosPub->getId(); ?>" type="radio" value="Porto Novo 2"/>
                        <span>Porto Novo 2</span>
                    </label></p>
                    <p><label>
                        <input name="group-<?php echo $dadosPub->getId(); ?>" type="radio" value="Presidente Médici"/>
                        <span>Presidente Médici</span>
                    </label></p>
                    <p><label>
                        <input name="group-<?php echo $dadosPub->getId(); ?>" type="radio" value="Morro do Sesi"/>
                        <span>Morro do Sesi</span>
                    </label></p>
                    <p><label>
                        <input name="group-<?php echo $dadosPub->getId(); ?>" type="radio" value="Del Porto"/>
                        <span>Del Porto</span>
                    </label></p>
                    <button type="submit" name="btn-up-gru-<?php echo $dadosPub->getId(); ?>" class="btn-small blue darken-2">Confirmar</button>
                    <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                </form>
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="modal-up-acc-<?php echo $dadosPub->getId(); ?>" class="modal">
            <div class="modal-content">
                <p>Defina o nível de acesso do publicador</p>
                <form action="phpaction/update_pub.php" method="POST">
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="-1"/>
                        <span>Desassociado</span>
                    </label></p>
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="1" checked/>
                        <span>Publicador nv 1</span>
                    </label></p>
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="2"/>
                        <span>Publicador nv 2</span>
                    </label></p>
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="3"/>
                        <span>Publicador nv 3</span>
                    </label></p>
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="4"/>
                        <span>Publicador nv 4</span>
                    </label></p>
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="5"/>
                        <span>Publicador nv 5</span>
                    </label></p>
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="6"/>
                        <span>Publicador nv 6</span>
                    </label></p>
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="7"/>
                        <span>Publicador nv 7</span>
                    </label></p>
                    <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="8"/>
                        <span>Publicador nv 8</span>
                    </label></p>
                    <?php
                    if ($publicador->getAccess() == 10) :
                        ?>
                        <p><label>
                        <input name="acc-<?php echo $dadosPub->getId(); ?>" type="radio" value="9"/>
                        <span>Publicador nv 9</span>
                    </label></p>
                        <?php
                    endif;
                    ?>
                    <button type="submit" name="btn-up-acc-<?php echo $dadosPub->getId(); ?>" class="btn-small blue darken-2">Confirmar</button>
                    <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                </form>
            </div>
        </div>
        <?php
    endfor;
    ?>
</table>

<script>
$(document).ready(function(){
    $('.modal').modal();
});
</script>
    
<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
