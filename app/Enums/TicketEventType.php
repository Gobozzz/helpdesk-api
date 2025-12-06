<?php

declare(strict_types=1);

namespace App\Enums;

enum TicketEventType: string
{
    case ASSIGNED = 'assigned';
    case STATUS_CHANGED = 'status_changed';
    case CREATED = 'created';
    case COMMENT = 'comment';
}
