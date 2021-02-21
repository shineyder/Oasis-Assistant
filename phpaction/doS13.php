<?php

//* Página:
/*    Oculta - Ação PHP - Emitir S13
/*  Conteúdo:
/*    Lê informações do banco de dados e cria a planilha da S13.
**/

use Assistant\EventoDAO;

// Função redirect
require_once $_SERVER['DOCUMENT_ROOT'] . '/phpaction/redirect.php';

// Load Composer's autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Sessão
session_start();

//declaramos uma variavel para monstarmos a tabela
$dadosXls  = " ";
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
        $dadosXls .= "  <td colspan='2'>QUEM FEZ</td>";
    endfor;
    $dadosXls .= "      </tr>";
    $dadosXls .= "      <tr>";
    for ($j = 1; $j <= 24; $j++) :
        $dadosXls .= "  <td>QUANDO COMEÇOU</td>";
        $dadosXls .= "  <td>QUANDO TERMINOU</td>";
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
