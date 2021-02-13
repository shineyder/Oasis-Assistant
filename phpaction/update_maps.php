<!--
Página:
    Oculta - Ação PHP - Atualizar mapas
Conteúdo:
    Atualiza a informação do servidor com respeito aos dados das quadras. 
-->

<?php

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Sessão
session_start();

// Conexão
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/connect.php';

if (isset($_POST['btn-env-rel'])) :
    $id_first = $_POST['first'];
    $id_last = $_POST['last'];

    for ($i = $id_first; $i <= $id_last; $i++) {
        $trab = (isset($_POST['trab_' . $i]) ? "1" : "0");
        $n_res = $_POST['n_res_' . $i];
        $n_com = $_POST['n_com_' . $i];
        $n_edi = $_POST['n_edi_' . $i];

        $sql = "UPDATE mapas SET trab = '$trab', n_residencia = '$n_res', n_comercio = '$n_com', n_edificio = '$n_edi' WHERE id = '$i'";
        $stmt = conectar\Connect::conn()->prepare($sql);
        $stmt->execute();
    }
    $stmt = conectar\Connect::closeConn();
    redirect('http://oasisassistant.com/fazer_rel.php#' . $_POST['mapactive']);
    exit();
endif;
