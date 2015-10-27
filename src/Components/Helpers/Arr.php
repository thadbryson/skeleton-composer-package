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

    public function at(array $var, $index, $length = 1)
    {
        return array_slice($var, $index, $length);
    }

    public function first(array $var)
    {
        return $this->at($var, 0, 1);
    }

    public function last(array $var)
    {
        return $this->at($var, count($var) - 1, 1);
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

    public function accessorExecute(array $value, $method, array $params = [])
    {
        // Get the property and its accessor.
        $property = $this->accessProp($method);
        $accessor = $this->accessorType($method);

        if ($accessor === 'dot') {
            // dot: dot, default
            return chain($value)
                ->dot($property, [])
                ->dot($params[0], @$params[1] or null)
            ;
        }
        elseif ($accessor === 'add') {
            // add: key, value
            $value[$params[0]] = $params[1];
        }
        elseif ($accessor === 'addElement') {
            // add: element
            $value[] = $params[0];
        }
        elseif ($accessor === 'remove') {
            // remove: key
            unset($value[$params[0]]);
        }
        elseif ($accessor === 'removeElement') {
            // remove: element
            return chain($value)->arr_removeElement($params[0]);
        }
        elseif ($accessor === 'clear') {
            return [];
        }
        elseif ($accessor === 'has') {
            // has: key
            return chain($value)->arr_hasKey($params[0]);
        }
        elseif ($accessor === 'hasElement') {
            // has: key
            return chain($value)->arr_hasElement($params[0]);
        }
        elseif ($accessor === 'first') {

            return chain($value)->arr_first();
        }
        elseif ($accessor === 'last') {

            return chain($value)->arr_last();
        }
        elseif ($accessor === 'at') {
            // at: index
            return chain($value)->arr_at($params[0]);
        }

        return $value;
    }
}
