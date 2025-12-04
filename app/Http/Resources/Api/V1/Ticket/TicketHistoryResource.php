<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\Ticket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TicketHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->getKey(),
            "subject" => $this->subject,
            "body" => $this->body,
            "priority" => $this->priority,
            "status" => $this->status,
            "user_id" => $this->user_id,
            "assigned_agent_id" => $this->assigned_agent_id,
            'events' => $this->events,
        ];
    }
}
