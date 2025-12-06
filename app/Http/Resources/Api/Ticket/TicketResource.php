<?php

namespace App\Http\Resources\Api\Ticket;

use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'subject' => $this->subject,
            'body' => $this->body,
            'priority' => $this->priority,
            'status' => $this->status,
            'user_id' => $this->user_id,
            'assigned_user_id' => $this->assigned_user_id,
            'created_at' => DateHelper::formatYMD($this->created_at),
        ];
    }
}
