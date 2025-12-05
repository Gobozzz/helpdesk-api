<?php

declare(strict_types=1);

namespace App\DTO\Ticket;

final readonly class TicketCreateDTO
{
    public function __construct(
        public string     $subject,
        public string     $body,
        public string     $priority,
        public string|int $user_id,
    )
    {
    }
}
