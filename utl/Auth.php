<?php

namespace utl;

class Auth
{
    public static function handleLogin()
    {
        @session_start();
        $logged = (isset($_SESSION['loggedIn'])) ? $_SESSION['loggedIn'] : false;
        if ($logged == false) :
            session_unset();
            session_destroy();
            header('Location: http://oasisassistant.com/');
            exit();
        endif;
    }

    public static function handleLogSession()
    {
        @session_start();
        $logged = (isset($_SESSION['loggedIn'])) ? $_SESSION['loggedIn'] : false;
        if ($logged == 1) :
            header('Location: http://oasisassistant.com/home');
            exit();
        endif;
    }

    public static function handleAccess($accessMin)
    {
        @session_start();
        $access = $_SESSION['access'];
        if ($access < $accessMin) :
            header('Location: http://oasisassistant.com/home');
            exit();
        endif;
    }
}
