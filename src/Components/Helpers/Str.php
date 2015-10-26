<?php

class Str
{


    public function begins($var, $substr)
    {
        return substr($var, 0, strlen($substr)) === $substr;
    }

    public function ends($var, $substr)
    {
        return substr($var, -1 * strlen($substr)) === $substr;
    }

    public function before($var, $substr, $occurence = 1)
    {
        $pos = strpos($var, $substr);

        return substr($var, 0, $pos);
    }

    public function after($var, $substr, $occurence = 1)
    {
        $pos = strpos($var, $substr);

        return substr($var, $pos);
    }

    public function has($var, $needle)
    {
        return strpos($var, $needle) !== false;
    }

    public function hasAll($var, array $needles)
    {
        foreach ($needles as $needle) {

            if ($this->has($var, $needle) === false) {
                return false;
            }
        }

        return true;
    }

    public function hasAny($var, array $needles)
    {
        foreach ($needles as $needle) {

            if ($this->has($var, $needle) === true) {
                return true;
            }
        }

        return false;
    }

    public function dot($var)
    {
        return chain($var)
            ->explode('.')
        ;
    }
}