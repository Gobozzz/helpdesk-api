<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Ticket;

use App\DTO\Ticket\TicketCommentDTO;
use Illuminate\Foundation\Http\FormRequest;

final class CreateCommentTicketRequest extends FormRequest
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
            'text' => ['required', 'string', 'max:2000'],
        ];
    }

    public function getDto(): TicketCommentDTO
    {
        return new TicketCommentDTO(
            text: $this->get('text'),
            user_id: $this->user()->getKey(),
        );
    }
}
