<?php

if (function_exists('chain') === false) {

    function chain($var) {

        return new \AnonPain\Components\Macros\Chain($var);
    }
}
