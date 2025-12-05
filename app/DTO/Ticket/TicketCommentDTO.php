<?php

declare(strict_types=1);

namespace App\DTO\Ticket;

final readonly class TicketCommentDTO
{
    public function __construct(
        public string     $text,
        public string|int $user_id,
    )
    {
    }
}
