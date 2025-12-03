<?php

declare(strict_types=1);

namespace App\Services\Hash;

use Illuminate\Support\Facades\Hash;

final class LaravelHasher implements HasherContract
{
    public function make(string $value): string
    {
        return Hash::make($value);
    }

    public function sha256(string $value): string
    {
        return hash('sha256', $value);
    }

    public function verify(string $value, string $hashedValue): bool
    {
        return Hash::check($value, $hashedValue);
    }
}
