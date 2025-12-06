<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use App\DTO\Auth\RegisterDTO;
use Illuminate\Foundation\Http\FormRequest;

final class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function getDto(): RegisterDTO
    {
        return new RegisterDTO(
            name: $this->get('name'),
            email: $this->get('email'),
            password: $this->get('password'),
        );
    }
}
