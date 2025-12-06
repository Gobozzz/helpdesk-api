<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use App\DTO\Auth\LoginDTO;
use Illuminate\Foundation\Http\FormRequest;

final class LoginRequest extends FormRequest
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
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string'],
            'fingerprint' => ['required', 'string', 'max:255'],
        ];
    }

    public function getDto(): LoginDTO
    {
        return new LoginDTO(
            email: $this->get('email'),
            password: $this->get('password'),
            fingerprint: $this->get('fingerprint'),
        );
    }

}
