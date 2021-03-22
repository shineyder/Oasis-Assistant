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
            Redirect::redirect(URL);
            exit();
        endif;
    }

    public static function handleLogSession()
    {
        @session_start();
        $logged = (isset($_SESSION['loggedIn'])) ? $_SESSION['loggedIn'] : false;
        if ($logged == 1) :
            Redirect::redirect(URL . 'Home');
            exit();
        endif;
    }

    public static function handleAccess($accessMin)
    {
        @session_start();
        $access = $_SESSION['access'];
        if ($access < $accessMin) :
            Redirect::redirect(URL . 'Home');
            exit();
        endif;
    }
}
