<?php

//LEMBRETES: (APAGAR DPS DE FAZER 1 HOSPEDAGEM)
// TROCAR O TAMANHO DAS COLUNAS DO SERVIDOR: login, senha, usuario e semelhantes: VARCHAR 32
// AVALIAR TAMANHO DE OUTRAS COLUNAS E FAZER TROCAS DE ACORDO
// TROCAR AS SENHAS POR CONTA DA NOVA HASH

//NÃO MUDAR A HASH PARA NÃO FERRAR OS DADOS SALVOS NO SERVIDOR
//For other things
define('HASH_GEN_KEY', '_DontBelieveInLie_');
//For password only
define('HASH_PASS_KEY', '_BecauseItsNotTrue_');

//Constants: SERVER CONN OFFLINE
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'oasis_assistant');
define('DB_USER', 'root');
define('DB_PASS', '');

//PATH OFFLINE
define('URL', 'http://oasisassistant.com/');

//PATH ONLINE
//define('URL', 'https://oasisassistant.000webhostapp.com/');

date_default_timezone_set('America/Sao_Paulo');
