<?php

declare(strict_types=1);

namespace App\Enums;

enum LogLevel: string
{
    case EMERGENCY = 'emergency';
    case ALERT = 'alert';
    case CRITICAL = 'critical';
    case ERROR = 'error';
    case WARNING = 'warning';
    case NOTICE = 'notice';
    case INFO = 'info';
    case DEBUG = 'debug';

    public function label(): string
    {
        return match ($this) {
            self::EMERGENCY => 'Аварийное уведомление',
            self::ALERT => 'Важное уведомление',
            self::CRITICAL => 'Критическая ошибка',
            self::ERROR => 'Ошибка',
            self::WARNING => 'Предупреждение',
            self::NOTICE => 'Уведомление',
            self::INFO => 'Информационное сообщение',
            self::DEBUG => 'Отладка',
        };
    }
}
