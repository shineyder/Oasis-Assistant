<?php

namespace lib;

class View
{
    public function render($name)
    {
        require $_SERVER['DOCUMENT_ROOT'] . '/MVC/Views/' . $name . '.php';
    }
}
