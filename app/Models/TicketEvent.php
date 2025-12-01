<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TicketEventType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'type',
        'payload',
    ];

    protected function casts(): array
    {
        return [
            'type' => TicketEventType::class,
            'payload' => 'object',
        ];
    }

}
