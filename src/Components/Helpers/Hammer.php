<?php

class Hammer
{


    public function callMethod($object, $methodName, array $paramSets)
    {
        foreach ($paramSets as $params) {
            call_user_method_array($methodName, $object, $params);
        }

        return $this;
    }

    public function callMethodStatic($object, $methodName, array $paramSets)
    {
        if (is_object($object) === true) {
            $object = get_class($object);
        }

        $method = $object . '::' . $methodName;

        foreach ($paramSets as $params) {
            call_user_func_array($method, $params);
        }

        return $this;
    }

    public function callFunction($functionName, array $paramSets)
    {
        foreach ($paramSets as $params) {
            call_user_func_array($functionName, $params)l
        }

        return $this;
    }

    public function loop($whileLessThan, Callback $callback, $start = 0, $increment = 1)
    {
        $result = [];

        for ($index = $start, $index < $whileLessThan, $index += $increment) {

            $result[] = $callback($index, $start, $whileLessThan, $increment);
        }

        return $result;
    }

    public function loopMax(Callback $callback)
    {
        $whileLessThan = $this->getIntMax();
        $start         = $this->getIntMin();

        // Maximum amount of iterations: integer min to max.
        return $this->loop($whileLessThan, $callback, $start, 1);
    }

    public function getIntMax()
    {
        return PHP_INT_MAX;
    }

    public function getIntMin()
    {
        return PHP_INT_MIN;
    }
}