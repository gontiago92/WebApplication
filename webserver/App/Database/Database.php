<?php

namespace Database;

use PDO;

class Database 
{
    private static $pdo = null;
    private static $options;

    public static function getPDO()
    {
        if(is_null(self::$pdo)) {

            self::$options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ];

            self::$pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', self::$options);
        }

        return self::$pdo;
        
    }
    
}