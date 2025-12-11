<?php

declare(strict_types=1);

namespace App\Adapters\Logger\Messenger;

use App\Enums\LogLevel;
use Illuminate\Support\Facades\Http;

final class TelegramLogger implements MessengerLogContract
{
    private readonly string $token;

    private readonly string $chatId;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    protected function send(string $level, string $message): void
    {
        $message = mb_substr($message, 0, 4000);
        Http::post($this->get_base_url().'/sendMessage', [
            'chat_id' => $this->chatId,
            'text' => "[{$level}] {$message}",
        ]);
    }

    private function get_base_url(): string
    {
        return "https://api.telegram.org/bot{$this->token}";
    }

    public function emergency(string $message): void
    {
        $this->send(LogLevel::EMERGENCY->label(), $message);
    }

    public function alert(string $message): void
    {
        $this->send(LogLevel::ALERT->label(), $message);
    }

    public function critical(string $message): void
    {
        $this->send(LogLevel::CRITICAL->label(), $message);
    }

    public function error(string $message): void
    {
        $this->send(LogLevel::ERROR->label(), $message);
    }

    public function warning(string $message): void
    {
        $this->send(LogLevel::WARNING->label(), $message);
    }

    public function notice(string $message): void
    {
        $this->send(LogLevel::NOTICE->label(), $message);
    }

    public function info(string $message): void
    {
        $this->send(LogLevel::INFO->label(), $message);
    }

    public function debug(string $message): void
    {
        $this->send(LogLevel::DEBUG->label(), $message);
    }
}
