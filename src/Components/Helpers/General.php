<?php

class General
{
    public function abort($var, $message = null, $exceptionClass = '\\Exception')
    {
        $message = str($message)
            ->str_replace(':var', $this->var)
            ->str_replace(':result', $this->result)
        ;

        throw new {$exceptionClass}($message);
    }

    public function equals($var, $equals, $strict = true)
    {
        if ($strict === true && $var === $equals) {
            return true;
        }

        return $var == $equals;
    }

    public function changeTo($var, $changeTo)
    {
        return $changeTo;
    }

    public function ifTrue($var, $changeTo)
    {
        return $this->ifElse($var, true, $changeTo, $var, true);
    }

    public function ifFalse($var, $changeTo)
    {
        return $this->ifElse($var, false, $changeTo, $var, true);
    }

    public function ifNull($var, $changeTo)
    {
        return $this->ifElse($var, null, $changeTo, $var, true);
    }

    public function ifElse($var, $equals, $true, $false, $strict = true)
    {
        if ($this->equals($var, $equals, $strict) === true) {
            return $true;
        }

        return $false;
    }

    public function callback($var, $callback)
    {
        return $callback($var);
    }

    public function or($var, $default = null)
    {
        if (empty($var) === true) {
            return $default;
        }

        return $var;
    }

    public function orFail($var, $message = null, $exceptionClass = '\\Exception')
    {
        if (empty($var) === true) {
            $this->abort($message, $exceptionClass);
        }

        return $var;
    }
}