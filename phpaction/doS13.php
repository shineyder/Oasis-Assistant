<?php
session_start();

//* Página:
/*    Oculta - Ação PHP - Emitir S13
/*  Conteúdo:
/*    Lê informações do banco de dados e cria a planilha da S13.
**/

use Assistant\EventoDAO;
use Assistant\MapasDAO;
use Assistant\PublicadorDAO;

header('Content-Type: text/html; charset=UTF-8');

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Declaramos uma variavel para monstarmos a tabela

$dadosXls  = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />";
$dadosXls .= "<table border='1'>";
$dadosXls .= "<tr>";
for ($i = 1; $i <= 24; $i++) :
    $dadosXls .= "<th colspan='2'>Mapa " . $i . "</th>";
endfor;
$dadosXls .= "</tr>";

$cobertNow = EventoDAO::getInstance()->cobertNow();
for ($i = 1; $i <= $cobertNow; $i++) :
    $dadosXls .= "<tr>";
    for ($j = 1; $j <= 24; $j++) :
        $mapaDAO = MapasDAO::getInstance()->firstLast($j);
        $id = EventoDAO::getInstance()->idS13($mapaDAO[0]['id'], $mapaDAO[1]['id'], $i);
        if ($id == false) :
            $dadosXls .= "<td colspan='2'></td>";
            continue;
        else :
            $name = PublicadorDAO::getInstance()->read('id', $id['id_user'], 'nome, sobrenome')->fetch(\PDO::FETCH_BOTH);
            $dadosXls .= "<td colspan='2'>" . $name['nome'] . " " . $name['sobrenome'] . "</td>";
        endif;
    endfor;
    $dadosXls .= "</tr>";
    $dadosXls .= "<tr>";
    for ($j = 1; $j <= 24; $j++) :
        $mapaDAO = MapasDAO::getInstance()->firstLast($j);
        $temp = EventoDAO::getInstance()->timeS13($mapaDAO[0]['id'], $mapaDAO[1]['id'], $i);
        if ($temp[0] == false) :
            $dadosXls .= "<td></td>";
            $dadosXls .= "<td></td>";
            continue;
        else :
            $dadosXls .= "<td>" . substr($temp[0]['timeN'], 0, strpos($temp[0]['timeN'], ' ')) . "</td>";
            $dadosXls .= "<td>" . substr($temp[1]['timeN'], 0, strpos($temp[1]['timeN'], ' ')) . "</td>";
        endif;
    endfor;
    $dadosXls .= "</tr>";
endfor;

$dadosXls .= "</table>";

// Definimos o nome do arquivo que será exportado
$arquivo = "S13.xls";

// Configurações header para forçar o download
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $arquivo . '"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Envia o conteúdo do arquivo
echo $dadosXls;
exit;
