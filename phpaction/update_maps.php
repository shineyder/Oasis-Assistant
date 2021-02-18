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

use Assistant\EventoDAO;
use Assistant\Eventos;
use Assistant\MapasDAO;

// Sessão
session_start();
//Dados
$dirigente = unserialize($_SESSION['obj']);

if (isset($_POST['btn-env-rel'])) :
    $id_first = $_POST['first'];
    $id_last = $_POST['last'];

    for ($i = $id_first; $i <= $id_last; $i++) {
        $dados_quadra = MapasDAO::getInstance()->read($i);
        $dados_quadra->setTrab(isset($_POST['trab_' . $i]) ? "1" : "0");
        $dados_quadra->setRes($_POST['n_res_' . $i]);
        $dados_quadra->setCom($_POST['n_com_' . $i]);
        $dados_quadra->setEdi($_POST['n_edi_' . $i]);
        MapasDAO::getInstance()->update($dados_quadra);

        if ($dados_quadra->getTrab() == 0 and ($dados_quadra->getRes() == 0 or $dados_quadra->getRes() == null) and ($dados_quadra->getCom() == 0 or $dados_quadra->getCom() == null) and ($dados_quadra->getEdi() == 0 or $dados_quadra->getEdi() == null)) :
            continue;
        endif;

        if (EventoDAO::getInstance()->isRel($i)->rowCount == 1) :
            $event = new Eventos(null, $dirigente->getId(), $dados_quadra->getId(), null, "attRel", "trab", $dados_quadra->getTrab(), "nRes", $dados_quadra->getRes(), "nCom", $dados_quadra->getCom(), "nEdi", $dados_quadra->getEdi(), null);
        else :
            $event = new Eventos(null, $dirigente->getId(), $dados_quadra->getId(), null, "doRel", "trab", $dados_quadra->getTrab(), "nRes", $dados_quadra->getRes(), "nCom", $dados_quadra->getCom(), "nEdi", $dados_quadra->getEdi(), null);
        endif;

        EventoDAO::getInstance()->create($event);
    }
    redirect('http://oasisassistant.com/fazer_rel.php#' . $_POST['mapactive']);
    exit();
endif;

$count = EventoDAO::getInstance()->relCount($dirigente->getId());

for ($i = 0; $i < $count; $i++) :
    if (isset($_POST['btn-up-rel-' . $i])) :
        $id_map = $_POST['id_map'];
        $dados_quadra = MapasDAO::getInstance()->read($id_map);
        $dados_quadra->setTrab(isset($_POST['trab_' . $i]) ? "1" : "0");
        $dados_quadra->setRes($_POST['n_res_' . $i]);
        $dados_quadra->setCom($_POST['n_com_' . $i]);
        $dados_quadra->setEdi($_POST['n_edi_' . $i]);
        MapasDAO::getInstance()->update($dados_quadra);

        $event = new Eventos(null, $dirigente->getId(), $dados_quadra->getId(), null, "attRel", "trab", $dados_quadra->getTrab(), "nRes", $dados_quadra->getRes(), "nCom", $dados_quadra->getCom(), "nEdi", $dados_quadra->getEdi(), null);
        EventoDAO::getInstance()->create($event);

        redirect('http://oasisassistant.com/my_relatorios.php');
        exit();
    endif;

    if (isset($_POST['btn-del-rel-' . $i])) :
        $id_map = $_POST['id_map'];

        $dados_quadra = MapasDAO::getInstance()->read($i);

        $event = new Eventos(null, $dirigente->getId(), $dados_quadra->getId(), null, "delRel", null, null, null, null, null, null, null, null, null);
        EventoDAO::getInstance()->create($event);

        $dados_quadra = MapasDAO::getInstance()->read($i);
        $dados_quadra->setTrab(isset($_POST['trab_' . $i]) ? "1" : "0");
        $dados_quadra->setRes($_POST['n_res_' . $i]);
        $dados_quadra->setCom($_POST['n_com_' . $i]);
        $dados_quadra->setEdi($_POST['n_edi_' . $i]);
        MapasDAO::getInstance()->update($dados_quadra);

        if ($dados_quadra->getTrab() == 0 and ($dados_quadra->getRes() == 0 or $dados_quadra->getRes() == null) and ($dados_quadra->getCom() == 0 or $dados_quadra->getCom() == null) and ($dados_quadra->getEdi() == 0 or $dados_quadra->getEdi() == null)) :
            continue;
        endif;

        redirect('http://oasisassistant.com/fazer_rel.php#' . $_POST['mapactive']);
        exit();
    endif;
endfor;
