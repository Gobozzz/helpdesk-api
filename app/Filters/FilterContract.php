<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterContract
{
    public function apply(Builder $query): Builder;

    public static function make(string $field, string $key): static;
}
