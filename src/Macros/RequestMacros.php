<?php

namespace ImLiam\Macros\Macros;

class RequestMacros
{
    /**
     * Replace a value in the request object.
     *
     * @param string|integer $key
     * @param mixed $value
     * @return self
     */
    public function replace() {
        return function($key, $value)
        {
            $this->merge([
                $key => $value,
            ]);

            return $this;
        };
    }
}
