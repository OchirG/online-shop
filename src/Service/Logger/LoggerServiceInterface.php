<?php

namespace Service\Logger;

interface LoggerServiceInterface
{
    public function error(\Throwable $exception, array $data = null);

    public function info(\Throwable $exception, array $data = null);

    public function warning(\Throwable $exception, array $data = null);

}

