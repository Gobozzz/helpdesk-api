<?php

declare(strict_types=1);

namespace App\Adapters\Hash;

interface HasherContract
{
    public function sha256(string $value): string;

    public function make(string $value): string;

    public function verify(string $value, string $hashedValue): bool;
}
