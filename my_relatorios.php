<!--
Página:
    Meus Relatórios
Conteúdo:
    Apresenta todos os relatórios feitos pelo usuário e permite alterar ou deletar relatórios feitos nas últimas 24hrs.
-->
<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\Eventos;
use Assistant\EventoDAO;

// Sessão
session_start();

//Verificação
if (!isset($_SESSION['logado'])) :
    redirect('http://oasisassistant.com/');
    exit();
endif;

//Dados
$dirigente = unserialize($_SESSION['obj']);

// Header
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
// Message
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/message.php';
?>

    <ul class="collection">
      <li class="collection-item"></li>
      <li class="collection-item"></li>
      <li class="collection-item"></li>
      <li class="collection-item"></li>
    </ul>

<?php
    //$evento = new Eventos($id, $idUser, $idMap, $time, $eventType, $data1, $desc1, $data2, $desc2, $data3, $desc3, $data4, $desc4, $cobert);
    //$eventoDAO = EventoDAO::getInstance()->create($evento);
?>

TEM Q FAZER ISSO AE TAOKEY ?

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
