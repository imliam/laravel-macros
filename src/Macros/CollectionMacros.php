<?php

namespace ImLiam\Macros\Macros;

use Carbon\Carbon;

class CollectionMacros
{
    /**
     * Sort the values in a collection by a datetime value.
     *
     * @param mixed $key
     *
     * @return Collection
     */
    public function sortByDate()
    {
        return function($key = null)
        {
            return $this->sortBy(function ($item) use ($key) {

                if (is_callable($key) && !is_string($key)) {
                    return $key($item);
                }

                $date = $key === null ? $item : $item[$key];

                if ($date instanceof Carbon) {
                    return $date->getTimestamp();
                }

                try {
                    return Carbon::parse($date)->getTimestamp();
                } catch (Exception $e) {
                }

                return 0;

            })->values();
        };
    }

    /**
     * Sort the values in a collection by a datetime value in reversed order.
     *
     * @param mixed $key
     *
     * @return Collection
     */
    public function sortByDateDesc()
    {
        return function($key = null)
        {
            return $this->sortByDate($key)->reverse();
        };
    }

    /**
     * Change the collection so that all values are equal to the corresponding key.
     *
     * Example: collect(['a' => 'b'])->keysToValues() // ['a' => 'a']
     */
    public function keysToValues()
    {
        return function()
        {
            return $this->mapWithKeys(function ($value, $key) {
                return [$key => $key];
            });
        };
    }

    /**
     * Change the collection so that all keys are equal to their corresponding value.
     *
     * Example: collect(['a' => 'b'])->valuesToKeys() // ['b' => 'b']
     */
    public function valuesToKeys()
    {
        return function()
        {
            return $this->mapWithKeys(function ($value, $key) {
                return [$value => $value];
            });
        };
    }
}
