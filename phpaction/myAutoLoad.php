<?php

function myAutoLoader($class)
{
    // Prefixo no namespace do projeto especifico
    //$prefix = '';

    // Diretorio aonde ficam as bibliotecas
    $base_dir = __DIR__ . '/DAO_Objetos/';

    // Verifica se a classe chamada usa o prefixo
    // $len = strlen($prefix);
    // if (strncmp($prefix, $class, $len) !== 0) {
        // Se não usar o prefixo Foo\bar então retorna false
    //    return;
    // }

    // Pega o caminho relativo da classe, ou seja remove o Foo\bar\
    // $relative_class = substr($class, $len);

    // Troca os separadores de namespace por separadores de diretorio
    // e adiciona o .php
    // $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    $file = $base_dir . $class . '.php';

    // Verifica se o arquivo existe, se existir então inclui ele
    if (is_file($file)) {
        include_once $file;
    }
}

spl_autoload_register('myAutoLoader');
