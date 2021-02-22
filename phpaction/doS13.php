<?php

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

// Sessão
session_start();

//declaramos uma variavel para monstarmos a tabela

$dadosXls  = "<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> ";
$dadosXls .= "<table border='1'> ";
$dadosXls .= "      <tr>";
for ($i = 1; $i <= 24; $i++) :
    $dadosXls .= "  <th colspan='2'>Mapa " . $i . "</th>";
endfor;
$dadosXls .= "      </tr>";

$cobertNow = EventoDAO::getInstance()->cobertNow();
for ($i = 1; $i <= $cobertNow; $i++) :
    $dadosXls .= "      <tr>";
    for ($j = 1; $j <= 24; $j++) :
        $mapaDAO = MapasDAO::getInstance()->firstLast($i);
        $id = EventoDAO::getInstance()->idS13($mapaDAO[0]['id'], $mapaDAO[1]['id']);
        $name = PublicadorDAO::getInstance()->read(['id', ''], [$id['id_user'], ''], 'nome, sobrenome');
        $name = $name->fetch(\PDO::FETCH_BOTH);
        $dadosXls .= "  <td colspan='2'>" . $name['nome'] . " " . $name['sobrenome'] . "</td>";
    endfor;
    $dadosXls .= "      </tr>";
    $dadosXls .= "      <tr>";
    for ($j = 1; $j <= 24; $j++) :
        $mapaDAO = MapasDAO::getInstance()->firstLast($i);
        $temp = EventoDAO::getInstance()->timeS13($mapaDAO[0]['id'], $mapaDAO[1]['id']);

        $temp[0]['timeN'] = 
        $dadosXls .= "          <td>" . $temp[0]['timeN'] . "</td>";
        $dadosXls .= "          <td>" . $temp[1]['timeN'] . "</td>";
    endfor;
    $dadosXls .= "      </tr>";
endfor;

//instanciamos
//$pdo = new Conexao();
//mandamos nossa query para nosso método dentro de conexao dando um return $stmt->fetchAll(PDO::FETCH_ASSOC);
//$result = $pdo->select("SELECT id,nome,email FROM cadastro");
//varremos o array com o foreach para pegar os dados
//foreach ($result as $res) :
//    $dadosXls .= "      <tr>";
//    $dadosXls .= "          <td>" . $res['id']."</td>";
//    $dadosXls .= "          <td>" . $res['nome']."</td>";
//    $dadosXls .= "          <td>" . $res['email']."</td>";
//    $dadosXls .= "      </tr>";
//endforeach;

$dadosXls .= "  </table>";

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
