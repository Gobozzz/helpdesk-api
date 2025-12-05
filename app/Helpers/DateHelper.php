<?php

declare(strict_types=1);

namespace App\Helpers;

use DateTimeInterface;

final readonly class DateHelper
{

    public static function formatYMD(DateTimeInterface $date, string $separator = "."): string
    {
        return $date->format("Y{$separator}m{$separator}d");
    }

    public static function formatYMDWithTime(DateTimeInterface $date, string $separator = "."): string
    {
        return $date->format("Y{$separator}m{$separator}d H:i");
    }

}
