<?php

namespace Warehouse;

class Logger
{
    public function log($message): void
    {
        file_put_contents('log.txt', date('Y-m-d H:i:s') . " - $message\n", FILE_APPEND);
    }
}