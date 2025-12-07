<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

final class AssignedTicketFilter extends BaseFilter implements FilterContract
{
    private const FILTER_ME = 'me';

    private const FILTER_UNASSIGNED = 'unassigned';

    public function apply(Builder $query): Builder
    {
        if (empty($this->getRequestValue())) {
            return $query;
        }
        if ($this->getRequestValue() === self::FILTER_ME) {
            return $query->where('assigned_agent_id', request()->user()->getKey());
        } elseif ($this->getRequestValue() === self::FILTER_UNASSIGNED) {
            return $query->whereNull('assigned_agent_id');
        }

        return $query;
    }
}
