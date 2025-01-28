<?php

namespace Service\Logger;

use Throwable;

class LoggerFileService implements LoggerServiceInterface
{
    public function error(string $message, array $data = null): void
    {
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $timestamp = date('Y-m-d H:i:s');

        $filePath = './../Storage/Log/error.txt';
        $errorMessage = "Ошибка: $message\nФайл: $file\nСтрока: $line\nВремя: $timestamp\n\n";

        file_put_contents($filePath, $errorMessage, FILE_APPEND);
    }

    public function warning(string $message, array $data = null): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $filePath = './../Storage/Log/warning.txt';
        $warningMessage = "Предупреждение: $message\nВремя: $timestamp\n\n";

        file_put_contents($filePath, $warningMessage, FILE_APPEND);
    }

    public function info(string $message, array $data = null): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $filePath = './../Storage/Log/info.txt';
        $infoMessage = "Информация: $message\nВремя: $timestamp\n\n";

        file_put_contents($filePath, $infoMessage, FILE_APPEND);
    }
}
