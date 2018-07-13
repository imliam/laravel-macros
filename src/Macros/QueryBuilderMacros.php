<?php

namespace ImLiam\Macros\Macros;

class QueryBuilderMacros
{
    /**
     * Conditionally add where clause to the query builder.
     *
     * @link https://themsaid.com/laravel-query-conditions-20160425
     */
    public function if()
    {
        return function ($condition, $column, $operator, $value) {
            if ($condition) {
                return $this->where($column, $operator, $value);
            }

            return $this;
        };
    }
}
