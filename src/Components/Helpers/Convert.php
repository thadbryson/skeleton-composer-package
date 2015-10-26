<?php

class Convert
{


    public function ifEquals($var, $equals, $convertTo)
    {
        if ($var === $equals) {
            return $convertTo;
        }

        return $var;
    }
}