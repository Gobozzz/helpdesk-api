<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InvalidFingerprintException extends Exception
{
    public function __construct()
    {
        parent::__construct('Invalid fingerprint', Response::HTTP_FORBIDDEN);
    }
}
