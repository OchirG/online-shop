<?php
namespace Model;

use PDO;
use PDOException;

class Model
{
    protected static ?PDO $pdo = null;

    public static function getPdo(): PDO {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            } catch (PDOException $e) {
                die("Ошибка подключения к базе данных: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}