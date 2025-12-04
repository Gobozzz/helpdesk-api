<?php

declare(strict_types=1);

namespace App\Filters\Groups;

use App\Filters\FilterContract;

interface FilterGroupContract
{
    /**
     * @return FilterContract[]
     */
    public static function filters(): array;
}
