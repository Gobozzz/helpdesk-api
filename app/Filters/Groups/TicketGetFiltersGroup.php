<?php

declare(strict_types=1);

namespace App\Filters\Groups;


use App\Filters\AssignedTicketFilter;
use App\Filters\BaseFilter;

final class TicketGetFiltersGroup implements FilterGroupContract
{
    public static function filters(): array
    {
        return [
            BaseFilter::make('status', 'status'),
            BaseFilter::make('priority', 'priority'),
            AssignedTicketFilter::make('assigned_agent_id', 'assigned'),
        ];
    }
}
