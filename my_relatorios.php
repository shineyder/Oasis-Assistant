<!--
Página:
    Meus Relatórios
Conteúdo:
    Apresenta todos os relatórios feitos pelo usuário e permite alterar ou deletar relatórios feitos nas últimas 24hrs.
-->
<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

//Dirigente e DirigenteDAO
require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/eventos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/DAO_Objetos/logEventosDao.php';

//Conexão
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/connect.php';

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
    $evento = new Evento\Eventos($id, $idUser, $idMap, $time, $eventType, $data1, $desc1, $data2, $desc2, $data3, $desc3, $data4, $desc4, $cobert);
    $eventoDAO = Evento\EventoDAO::getInstance()->create($evento);
?>


TEM Q FAZER ISSO AE TAOKEY ?

<?php
//Footer
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
?>
