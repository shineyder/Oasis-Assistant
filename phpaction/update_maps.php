<!--
Página:
    Oculta - Ação PHP - Atualizar mapas
Conteúdo:
    Atualiza a informação do servidor com respeito aos dados das quadras. 
-->

<?php

// Sessão
session_start();

// Conexão
require_once 'connect.php';

if (isset($_POST['btn-env-rel'])) :
    $id_first = $_POST['first'];
    $id_last = $_POST['last'];

    for ($i = $id_first; $i <= $id_last; $i++) {
        $trab = (isset($_POST['trab_' . $i]) ? "1" : "0");
        $n_res = $_POST['n_res_' . $i];
        $n_com = $_POST['n_com_' . $i];
        $n_edi = $_POST['n_edi_' . $i];

        $sql = "UPDATE mapas SET trab = '$trab', n_residencia = '$n_res', n_comercio = '$n_com', n_edificio = '$n_edi' WHERE id = '$i'";
        $stmt = connect::conn()->prepare($sql);
        $stmt->execute();
        $stmt = connect::closeConn();
    }
    header('Location: ../fazer_rel.php#' . $_POST['mapactive']);
endif;
