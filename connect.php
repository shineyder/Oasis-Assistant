<?php
class connect {
    private static $instance;
    protected static $servername = "localhost";
    protected static $username = "root";
    protected static $password = "";
    protected static $db_name = "mapsassistant";
    
    public static function conn(){
        if(!isset(self::$instance)):
            self::$instance = new \PDO("mysql:host=".self::$servername.";dbname=".self::$db_name."", self::$username, self::$password);
        endif;
        return self::$instance;
    }
    
    public static function closeConn(){
        if(isset(self::$instance)):
            self::$instance = null;
        endif;
        
        return self::$instance;
    }
}