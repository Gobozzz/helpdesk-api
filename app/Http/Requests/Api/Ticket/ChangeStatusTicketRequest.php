<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Ticket;

use App\DTO\Ticket\TicketChangeStatusDTO;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class ChangeStatusTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ["required", new Enum(TicketStatus::class)],
        ];
    }

    public function getDto(): TicketChangeStatusDTO
    {
        return new TicketChangeStatusDTO(
            status: TicketStatus::from($this->get('status')),
            user_id: $this->user()->getKey(),
        );
    }

}
