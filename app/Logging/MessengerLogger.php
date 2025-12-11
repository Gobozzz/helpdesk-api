<?php

declare(strict_types=1);

namespace App\Logging;

use App\Adapters\Logger\Messenger\MessengerLogContract;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;

final class MessengerLogger extends AbstractProcessingHandler
{
    private MessengerLogContract $messengerLog;

    public function __construct(
        $level = Level::Debug,
        bool $bubble = true,
    ) {
        parent::__construct($level, $bubble);
        $this->messengerLog = app(MessengerLogContract::class);
    }

    protected function write(LogRecord $record): void
    {
        $message = $record->message;
        switch ($record->level) {
            case Level::Emergency:
                $this->messengerLog->emergency($message);
                break;
            case Level::Alert:
                $this->messengerLog->alert($message);
                break;
            case Level::Critical:
                $this->messengerLog->critical($message);
                break;
            case Level::Error:
                $this->messengerLog->error($message);
                break;
            case Level::Warning:
                $this->messengerLog->warning($message);
                break;
            case Level::Notice:
                $this->messengerLog->notice($message);
                break;
            case Level::Info:
                $this->messengerLog->info($message);
                break;
            case Level::Debug:
                $this->messengerLog->debug($message);
                break;
        }
    }
}
