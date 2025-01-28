<?php

namespace Service\Logger;

use PDO;

class LoggerDbService implements LoggerServiceInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function error(string $message, array $data = null): void
    {
        $this->log('ERROR', $message, $data);
    }

    public function warning(string $message, array $data = null): void
    {
        $this->log('WARNING', $message, $data);
    }

    public function info(string $message, array $data = null): void
    {
        $this->log('INFO', $message, $data);
    }

    private function log(string $level, string $message, array $data = []): void
    {
        $timestamp = date('Y-m-d H:i:s');
        $stmt = $this->pdo->prepare("INSERT INTO logs (level, message, created_at) VALUES (:level, :message, :created_at)");
        $stmt->execute([
            ':level' => $level,
            ':message' => $message,
            ':created_at' => $timestamp,
        ]);
    }
}

