<?php

namespace Model;

class Logger extends Model
{
    public function log(string $level, \Throwable $exception): void
    {
        $message = $exception->getMessage();
        $timestamp = date('Y-m-d H:i:s');
        $stmt = self::getPdo()->prepare("INSERT INTO logs (level, message, created_at) VALUES (:level, :message, :created_at)");
        $stmt->execute([
            ':level' => $level,
            ':message' => $message,
            ':created_at' => $timestamp,
        ]);
    }
}