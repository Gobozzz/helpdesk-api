<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

final class AssignedTicketFilter extends BaseFilter implements FilterContract
{

    public function apply(Builder $query): Builder
    {
        if (empty($this->getRequestValue())) {
            return $query;
        }
        if ($this->getRequestValue() === "me") {
            return $query->where('assigned_agent_id', request()->user()->getKey());
        } else if ($this->getRequestValue() === "unassigned") {
            return $query->whereNull('assigned_agent_id');
        }
        return $query;
    }

}
