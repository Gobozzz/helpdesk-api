<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Models\Ticket;
use Illuminate\Support\Facades\Cache;

final class TicketCacheManager
{
    public const TTL_CACHE_TICKET = 120;

    public function allKey(string $filter_hash): string
    {
        return 'tickets:list:'.$filter_hash;
    }

    public function allByUserKey(string $filter_hash, string|int $user_id): string
    {
        return "tickets:list:users:$user_id:$filter_hash";
    }

    public function byIdKey(string|int $ticket_id): string
    {
        return 'ticket:'.$ticket_id;
    }

    public function allTag(): string
    {
        return 'tickets';
    }

    public function allByUserTag(string|int $user_id): string
    {
        return "tickets:list:users:$user_id";
    }

    public function invalidate(Ticket $ticket): void
    {
        Cache::forget($this->byIdKey($ticket->getKey()));
        Cache::tags($this->allByUserTag($ticket->user_id))->flush();
        Cache::tags($this->allTag())->flush();
    }
}
