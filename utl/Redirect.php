<?php

namespace utl;

class Redirect
{
    public static function redirect($url)
    {
        if (headers_sent()) {
            die('<script type="text/javascript">window.location=\'' . $url . '\';</script>');
        } else {
            header('Location: ' . $url);
            die();
        }
    }
}
