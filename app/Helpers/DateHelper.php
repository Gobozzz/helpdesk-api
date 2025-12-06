<?php

declare(strict_types=1);

namespace App\Helpers;

use DateTimeInterface;

final readonly class DateHelper
{
    public static function formatYMD(DateTimeInterface $date): string
    {
        return $date->format('Y.m.d');
    }

    public static function formatYMDWithTime(DateTimeInterface $date): string
    {
        return $date->format('Y.m.d H:i');
    }
}
