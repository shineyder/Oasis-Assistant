<?php

namespace Assistant;

class Connect
{
    private static $instance;
    protected static $servername = "localhost";
    protected static $username = "id16295567_shineyder";
    protected static $password = "6!h6/&>tg[A&CdQV";
    protected static $db_name = "id16295567_oasis_assistant";

    public static function conn()
    {
        if (!isset(self::$instance)) :
            self::$instance = new \PDO("mysql:host=" . self::$servername . ";dbname=" . self::$db_name . "", self::$username, self::$password);
        endif;
        return self::$instance;
    }

    public static function closeConn()
    {
        if (isset(self::$instance)) :
            self::$instance = null;
        endif;
        return self::$instance;
    }
}
