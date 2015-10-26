<?php

class Arr
{


    public function each(array $var, $action)
    {
        $return = [];

        foreach ($var as $key => $value) {

            $return[$key] = call_user_func_array($valueAction, [$key, $value, $var]);
        }

        return $return;
    }

    public function dot(array $var, $dot, $default = null)
    {
        if (is_string($dot)) {
            $dot = str($dot)->dot()->get();
        }

        // Remove first key off dot.
        $key = array_shift($dot);

        if ($this->hasKey($var, $key) === false) {
            return $default;
        }

        $var = $var[$key];

        if (count($dot) === 0) {
            return $var;
        }

        return $this->find($var, $dot, $default);
    }

    public function hasKey(array $var, $key)
    {
       try {
            // Check for null. If isset() is false it could be null.
            $var[$key];
        }
        catch (\Exception $e) {
            // Didn't work: return false.
            return false;
        }

        // All good: we have the key.
        return true;
    }

    public function swap(array $var, $firstIndex, $secondIndex)
    {
        $first  = $var[$firstIndex];
        $second = $var[$secondIndex];

        $var[$firstIndex]  = $second;
        $var[$secondIndex] = $first;

        return $var;
    }

    public function removeFirstNumElements(array $var, $num)
    {
        return array_slice($var, 0, $num);
    }

    public function removeLastNumElements(array $var, $num)
    {
        return array_slice($var, -1 * $num);
    }
}
