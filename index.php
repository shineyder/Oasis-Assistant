<?php

require $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

date_default_timezone_set('America/Sao_Paulo');

$app = new lib\Bootstrap();
$app->init();
