<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Auth;

use App\DTO\Auth\RefreshDTO;
use App\Traits\HasRefreshTokenRequest;
use Illuminate\Foundation\Http\FormRequest;

final class RefreshTokenRequest extends FormRequest
{
    use HasRefreshTokenRequest;

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
            'refresh_token' => ['nullable', 'string'],
            'fingerprint' => ['required', 'string', 'max:255'],
        ];
    }

    public function getDto(): RefreshDTO
    {
        return new RefreshDTO(
            refresh_token: $this->getRefreshToken(),
            fingerprint: $this->get('fingerprint')
        );
    }

}
