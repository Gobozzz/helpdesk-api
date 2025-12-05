<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\TicketEvent;

use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TicketEventResource extends JsonResource
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
            'type' => $this->type,
            'payload' => $this->payload,
            'created_at' => DateHelper::formatYMDWithTime($this->created_at),
        ];
    }
}
