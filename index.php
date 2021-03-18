<?php

require $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$app = new lib\Bootstrap();
$app->init();
