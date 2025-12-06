<?php

declare(strict_types=1);

namespace App\DTO\Ticket;

use App\Enums\TicketStatus;

final readonly class TicketChangeStatusDTO
{
    public function __construct(
        public TicketStatus $status,
        public string|int $user_id,
    ) {}
}
