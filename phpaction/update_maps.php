<!--
Página:
    Oculta - Ação PHP - Atualizar mapas
Conteúdo:
    Atualiza a informação do servidor com respeito aos dados das quadras. 
-->

<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Assistant\MapasDAO;

if (isset($_POST['btn-env-rel'])) :
    $id_first = $_POST['first'];
    $id_last = $_POST['last'];

    for ($i = $id_first; $i <= $id_last; $i++) {
        $dados_quadra = MapasDAO::getInstance()->read($i);
        $dados_quadra->setTrab(isset($_POST['trab_' . $i]) ? "1" : "0");
        $dados_quadra->setRes($_POST['n_res_' . $i]);
        $dados_quadra->setCom($_POST['n_com_' . $i]);
        $dados_quadra->setEdi($_POST['n_edi_' . $i]);

        $mapDAO = MapasDAO::getInstance()->update($dados_quadra);
    }
    redirect('http://oasisassistant.com/fazer_rel.php#' . $_POST['mapactive']);
    exit();
endif;
