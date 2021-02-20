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
if ($publicador->getAccess() <= 8) :
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
                <a href="#modal-up-acc-<?php echo $i; ?>" class="btn-small blue darken-4 modal-trigger">Definir Acesso</a>
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
            <!--
            <div id="modal-up-acc-<?php //echo $i; ?>" class="modal">
                <div class="modal-content">
                    <p>Defina o nível de acesso do publicador</p>
                    <form action="phpaction/update_pub.php" method="POST">
                        <input type="hidden" name="id" value="<?php //echo $dados->getId(); ?>">
                        
                        <div class="input-field col s5">
                            <select id="grup" name="grup">
                            <option value="" disabled selected>Selecione uma opção</option>
                            <option value="1">Porto Novo 1</option>
                            <option value="2">Porto Novo 2</option>
                            <option value="3">Presidente Médici</option>
                            <option value="4">Morro do Sesi</option>
                            <option value="5">Del Porto</option>
                            </select>
                        </div>
                        <button type="submit" name="btn-up-gru-<?php //echo $i; ?>" class="btn-small blue darken-2">Confirmar</button>
                        <a href="#!" class="modal-action modal-close waves-effect btn-small red darken-2">Cancelar</a>
                    </form>
                </div>
            </div>-->
        </li>
        <?php
    endfor;
    ?>
</ul>

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
