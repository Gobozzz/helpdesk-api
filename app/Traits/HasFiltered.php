<?php

declare(strict_types=1);

namespace App\Traits;

use App\Filters\FilterContract;
use Illuminate\Database\Eloquent\Builder;

trait HasFiltered
{
    /**
     * @param  FilterContract[]  $filters
     */
    public function scopeFiltered(Builder $query, array $filters): Builder
    {
        foreach ($filters as $filter) {
            $query = $filter->apply($query);
        }

        return $query;
    }
}
