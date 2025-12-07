<?php

declare(strict_types=1);

namespace App\Filters\Groups;

use App\Adapters\Hash\HasherContract;

abstract class BaseFilterGroup
{
    public static function getHashFilters(): string
    {
        $filtered_key_value_string = '';
        foreach (static::filters() as $filter) {
            if (empty($filter->getRequestValue())) {
                continue;
            }
            if (is_string($filter->getRequestValue())) {
                $filtered_key_value_string .= $filter->getRequestedKey().'='.$filter->getRequestValue();
            } elseif (is_array($filter->getRequestValue())) {
                $filtered_key_value_string .= $filter->getRequestedKey().'='.implode(',', $filter->getRequestValue());
            }
        }
        if (request()->has('page') && is_string(request()->get('page'))) {
            $filtered_key_value_string .= 'page='.request()->get('page');
        }

        return app()->make(HasherContract::class)->sha256($filtered_key_value_string);
    }
}
