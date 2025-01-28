<?php

namespace Service\Logger;

interface LoggerServiceInterface
{
    public function error(string $message, array $data = null);

    public function info(string $message, array $data = null);

    public function warning(string $message, array $data = null);

}