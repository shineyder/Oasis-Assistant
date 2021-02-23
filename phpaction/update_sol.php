<!--
Página:
    Oculta - Ação PHP - Atualizar Solicitação
Conteúdo:
    Atualiza a informação do servidor com respeito ao status da solicitação. 
-->

<?php

// Função redirect

require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Sessão
session_start();

use Assistant\FaleConoscoDAO;

$countSol = FaleConoscoDAO::getInstance()->solCount("Problema");
var_dump($_POST);

for ($i = 1; $i <= $countSol; $i++) :
    $ini = $i - 1;
    if (isset($_POST['btn-up-sol-pro-' . $i])) :
        $dadosSol = FaleConoscoDAO::getInstance()->read("Problema", $ini);
        $statusN = $_POST['sol-pro-' . $i];
        $dadosSol->setStatus($statusN);
        FaleConoscoDAO::getInstance()->update($dadosSol);
        redirect('http://oasisassistant.com/master_page.php');
        exit();
    endif;
endfor;

$countSol = FaleConoscoDAO::getInstance()->solCount("Sugestão");

for ($i = 1; $i <= $countSol; $i++) :
    $ini = $i - 1;
    if (isset($_POST['btn-up-sol-sug-' . $i])) :
        $dadosSol = FaleConoscoDAO::getInstance()->read("Sugestão", $ini);
        $statusN = $_POST['sol-sug-' . $i];
        $dadosSol->setStatus($statusN);
        FaleConoscoDAO::getInstance()->update($dadosSol);
        redirect('http://oasisassistant.com/master_page.php');
        exit();
    endif;
endfor;

$countSol = FaleConoscoDAO::getInstance()->solCount("Outro");

for ($i = 1; $i <= $countSol; $i++) :
    $ini = $i - 1;
    if (isset($_POST['btn-up-sol-out-' . $i])) :
        $dadosSol = FaleConoscoDAO::getInstance()->read("Outro", $ini);
        $statusN = $_POST['sol-out-' . $i];
        $dadosSol->setStatus($statusN);
        FaleConoscoDAO::getInstance()->update($dadosSol);
        redirect('http://oasisassistant.com/master_page.php');
        exit();
    endif;
endfor;
