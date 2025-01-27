<?php
namespace Model;

use PDO;
use PDOException;

class Model
{
    protected static ?PDO $pdo = null; // Инициализация со значением null

    public static function getPdo(): PDO {
        if (self::$pdo === null) {
            try {
                self::$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Установка режима ошибок
            } catch (PDOException $e) {
                // Обработка ошибки подключения
                // Можно вывести сообщение в лог или обработать ошибку по-другому
                die("Ошибка подключения к базе данных: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}