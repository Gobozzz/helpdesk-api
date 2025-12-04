<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Closure;

class BaseFilter implements FilterContract
{
    protected string $prefix_filter_request = "filter_";

    protected string $field;

    protected string $key;

    protected string $operator = "=";

    protected ?string $relatedField = null;

    protected ?Closure $customQuery = null;

    public static function make(string $field, string $key): static
    {
        $filter = new static();
        $filter->field = $field;
        $filter->key = $key;
        return $filter;
    }

    public function apply(Builder $query): Builder
    {
        if (empty($this->getRequestValue())) {
            return $query;
        }

        if ($this->hasCustomQuery()) {
            return $query->where($this->customQuery);
        }

        if ($this->hasRelatedQuery()) {
            return $query->whereHas($this->field, function (Builder $q) {
                return is_array($this->getRequestValue())
                    ? $q->whereIn($this->relatedField, $this->getRequestValue())
                    : $q->where($this->relatedField, $this->operator, $this->getRequestValue());
            });
        }

        if (is_array($this->getRequestValue())) {
            return $query->whereIn($this->field, $this->operator, $this->getRequestValue());
        } else {
            return $query->where($this->field, $this->operator, $this->getRequestValue());
        }

    }

    protected function getRequestValue(): mixed
    {
        return request($this->prefix_filter_request . $this->key);
    }

    public function operator(string $operator): static
    {
        $this->operator = $operator;
        return $this;
    }

    public function customQuery(Closure $customQuery): static
    {
        $this->customQuery = $customQuery;
        return $this;
    }

    protected function hasCustomQuery(): bool
    {
        return !is_null($this->customQuery);
    }

    protected function relatedField(string $relatedField): static
    {
        $this->relatedField = $relatedField;
        return $this;
    }

    protected function hasRelatedQuery(): bool
    {
        return !is_null($this->relatedField);
    }

}
