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
use Assistant\EventoDAO;

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

<ul class="collapsible">
    <?php
    $countPub = PublicadorDAO::getInstance()->lastId();
    $countPub = intval($countPub['id']);

    for ($i = 1; $i <= $countPub; $i++) :
        $dados = PublicadorDAO::getInstance()->readAll(['id', ''], [$i, '']);
        ?>
        <li>
            <div class="collapsible-header">
                <?php echo $dados->getNome() . " " . $dados->getSobrenome(); ?>
            </div>
            <div class="collapsible-body">
                <?php
                echo "Relatórios feitos: " . EventoDAO::getInstance()->relCount($i) . "<br>";
                echo "Usuário: " . $dados->getUsuario() . "<br>";
                echo "E-mail: " . $dados->getEmail() . "<br>";
                echo "Grupo: " . (($dados->getGrupo() == null) ? "à definir" : $dados->getGrupo()) . "<br>";
                echo "Nível de acesso: " . $dados->getAccess() . "<br>";
                ?>
                <a href="#modal-up-gru-<?php echo $i; ?>" class="btn-small blue darken-2 modal-trigger">Definir Grupo</a>
                <?php
                if ($publicador->getId() != $i) :
                    ?>
                <a href="#modal-up-acc-<?php echo $i; ?>" class="btn-small blue darken-4 modal-trigger">Definir Acesso</a>
                    <?php
                endif;
                ?>
            </div>

            <!-- Modal Structure -->
            <div id="modal-up-gru-<?php echo $i; ?>" class="modal" style="height: 400px;">
                <div class="modal-content">
                    <p>Defina o Grupo ao qual o publicador pertence</p>
                    <form action="phpaction/update_pub.php" method="POST">
                        <div class="input-field col s5">
                            <select id="grup" name="grup">
                            <option value="" disabled selected>Selecione uma opção</option>
                            <option value="Porto Novo 1">Porto Novo 1</option>
                            <option value="Porto Novo 2">Porto Novo 2</option>
                            <option value="Presidente Médici">Presidente Médici</option>
                            <option value="Morro do Sesi">Morro do Sesi</option>
                            <option value="Del Porto">Del Porto</option>
                            </select>
                        </div>
                        <button type="submit" name="btn-up-gru-<?php echo $i; ?>" class="btn-small blue darken-2">Confirmar</button>
                        <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                    </form>
                </div>
            </div>

            <!-- Modal Structure -->
            <div id="modal-up-acc-<?php echo $i; ?>" class="modal">
                <div class="modal-content">
                    <p>Defina o nível de acesso do publicador</p>
                    <form action="phpaction/update_pub.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $dados->getId(); ?>">
                        
                        <div class="input-field col s5">
                            <select id="acc" name="acc">
                            <option value="" disabled selected>Selecione uma opção</option>
                            <option value="-1">Desassociado</option>
                            <option value="1">Publicador nv 1</option>
                            <option value="2">Publicador nv 2</option>
                            <option value="3">Publicador nv 3</option>
                            <option value="4">Publicador nv 4</option>
                            <option value="5">Publicador nv 5</option>
                            <option value="6">Publicador nv 6</option>
                            <option value="7">Publicador nv 7</option>
                            <option value="8">Publicador nv 8</option>
                            <?php
                            if ($publicador->getAccess() == 10) :
                                ?>
                                <option value="9">Publicador nv 9</option>
                                <?php
                            endif;
                            ?>
                            </select>
                        </div>
                        <button type="submit" name="btn-up-acc-<?php echo $i; ?>" class="btn-small blue darken-2">Confirmar</button>
                        <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                    </form>
                </div>
            </div>
        </li>
        <?php
    endfor;
    ?>
</ul>



<table >
    <thead>
        <tr>
            <th>Nome</th>
            <th>Sobrenome</th>
            <th>Usuário</th>
            <th>E-mail</th>
            <th>Grupo</th>
            <th>Acesso</th>
            <th>Definir Grupo</th>
            <th>Definir Acesso</th>
        <tr>
    </thead>
    <tbody>
        <?php
        $countPub = PublicadorDAO::getInstance()->lastId();
        $countPub = intval($countPub['id']);

        for ($i = 1; $i <= $countPub; $i++) :
            $dados = PublicadorDAO::getInstance()->readAll(['id', ''], [$i, '']);
            ?>
            <tr>
                <td><?php echo $dados->getNome(); ?></td>
                <td><?php echo $dados->getSobrenome(); ?></td>
                <td><?php echo $dados->getUsuario(); ?></td>
                <td><?php echo $dados->getEmail(); ?></td>
                <td><?php echo $dados->getGrupo(); ?></td>
                <td><?php echo $dados->getAccess(); ?></td>
                <td><a href="#modal-up-gru-<?php echo $i; ?>" class="btn-small blue darken-2 modal-trigger">Definir Grupo</a></td>
                <td>
                <?php if ($publicador->getId() != $i) :?> 
                    <a href="#modal-up-acc-<?php echo $i; ?>" class="btn-small blue darken-4 modal-trigger">Definir Acesso</a>
                <?php endif; ?></td>
            </tr>
            <?php
        endfor;
        ?>
    </tbody>
</table>


<!--TENTA ADAPTAR ESSA MERDA-->
<?php
$action = '';
$where = '';
if (isset($_GET["id"])) :
    $id = $_GET["id"];
    $action = $_GET["action"];

    if ($action == 'ASC') :
        $action = 'DESC';
    else :
        $action = 'ASC';
    endif;

    if ($_GET['id'] == 'id') :
        $id = "e_id";
    else :
        if ($_GET['id'] == 'name') :
            $id = "name";
        else :
            if ($_GET['id'] == 'department') :
                $id = "department";
            else :
                if ($_GET['id'] == 'salary') :
                    $id = "salary";
                endif;
            endif;
        endif;
    endif;
    $where = " ORDER BY  $id $action ";
    $sql = "SELECT * FROM employee " . $where;
endif;
?>

<table>
    <tr>
        <th><a href="employee_record.php?id=<?php echo 'id';?>&action=<?php echo $action;?>">ID</a></th>
        <th><a href="employee_record.php?id=<?php echo 'name';?>&action=<?php echo $action;?>">NAME</a></th>
        <th><a href="employee_record.php?id=<?php echo 'department';?>&action=<?php echo $action;?>">DEPARTMENT</a></th>
        <th><a href="employee_record.php?id=<?php echo 'salary';?>&action=<?php echo $action;?>">SALARY</a></th>
    </tr>
    <?php
    $result = $conn->query($sql);
    if ($result->num_rows > 0) :
        while ($row = $result->fetch_assoc()) :?>
            <tr>
                <td><?php echo $row["e_id"];?></td>
                <td><?php echo $row["name"];?></td>
                <td><?php echo $row["department"];?></td>
                <td><?php echo "$" . $row["salary"];?></td>
            </tr> 
            <?php
        endwhile;
        echo '</table>';
        echo '</div>';
    else :
        echo "0 results";
    endif;
    ?>

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
