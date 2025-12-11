<?php

declare(strict_types=1);

namespace App\Adapters\Logger;

use Illuminate\Support\Facades\Log;

final class LoggerFacade implements LoggerContract
{
    public function emergency(string $message): void
    {
        Log::emergency($message);
    }

    public function alert(string $message): void
    {
        Log::alert($message);
    }

    public function critical(string $message): void
    {
        Log::critical($message);
    }

    public function error(string $message): void
    {
        Log::error($message);
    }

    public function warning(string $message): void
    {
        Log::warning($message);
    }

    public function notice(string $message): void
    {
        Log::notice($message);
    }

    public function info(string $message): void
    {
        Log::info($message);
    }

    public function debug(string $message): void
    {
        Log::debug($message);
    }
}
