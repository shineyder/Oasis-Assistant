<?php

namespace Assistant;

class Connect
{
    private static $instance;
    protected static $servername = "localhost";
    protected static $username = "root";
    protected static $password = "";
    protected static $db_name = "oasis_assistant";

    public static function conn()
    {
        if (!isset(self::$instance)) :
            self::$instance = new \PDO("mysql:host=" . self::$servername . ";dbname=" . self::$db_name . "", self::$username, self::$password);
            try {
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e) {
                self::$instance = null;
                die($e->getMessage());
            }
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
