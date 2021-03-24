<?php

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
