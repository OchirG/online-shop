<?php

namespace Service;
use Throwable;

class LoggerService
{
    public static function log(Throwable $exception): void
    {
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $timestamp = date('Y-m-d H:i:s');

        $filePath = './../Storage/Log/error.txt';
        $errorMessage = "Ошибка: $message\nФайл: $file\nСтрока: $line\nВремя: $timestamp\n\n";

        file_put_contents($filePath, $errorMessage, FILE_APPEND);
    }
}