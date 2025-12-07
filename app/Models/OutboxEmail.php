<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TicketEventType;
use Illuminate\Database\Eloquent\Model;

final class OutboxEmail extends Model
{
    protected $fillable = [
        "ticket_id",
        "event_type",
    ];

    protected function casts(): array
    {
        return [
            'event_type' => TicketEventType::class,
        ];
    }

}
