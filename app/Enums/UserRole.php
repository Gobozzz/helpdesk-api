<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';

    case AGENT = 'agent';

    case ADMIN = 'admin';

}
