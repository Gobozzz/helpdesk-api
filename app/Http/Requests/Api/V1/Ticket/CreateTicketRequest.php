<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Ticket;

use App\DTO\Ticket\TicketCreateDTO;
use App\Enums\TicketPriority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class CreateTicketRequest extends FormRequest
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
            'subject' => "required|string|max:255",
            'body' => "required|string|max:6000",
            'priority' => ['required', new Enum(TicketPriority::class)],
        ];
    }

    public function getDto(): TicketCreateDTO
    {
        return new TicketCreateDTO(
            subject: $this->get('subject'),
            body: $this->get('body'),
            priority: $this->get('priority'),
        );
    }

}
