<?php

//NÃO MUDAR A HASH PARA NÃO FERRAR OS DADOS SALVOS NO SERVIDOR
//Para uso geral
define('HASH_GEN_KEY', '_DontBelieveInLie_');
//Para uso em senhas
define('HASH_PASS_KEY', '_BecauseItsNotTrue_');

//Constantes: DADOS DE CONECÇÃO OFFLINE
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'oasis_assistant');
define('DB_USER', 'root');
define('DB_PASS', '');

//CAMINHO OFFLINE
define('URL', 'http://oasisassistant.com/');
