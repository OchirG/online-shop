<?php

namespace Service\Logger;

use Model\Logger;
use PDO;

class LoggerDbService implements LoggerServiceInterface
{
    private Logger $logger;


    public function __construct(Logger $logger)
    {
        $this->logger = $logger;

    }

    public function error(\Throwable $exception, array $data = null): void
    {
        $this->logger->log('ERROR', $exception);
    }

    public function warning(\Throwable $exception, array $data = null): void
    {
        $this->logger->log('WARNING', $exception);
    }

    public function info(\Throwable $exception, array $data = null): void
    {
        $this->logger->log('INFO', $exception);
    }
}

