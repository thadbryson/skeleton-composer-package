<?php

namespace AnonPain\Toolbox\Helpers;

class Helper
{

    public function get($helper)
    {
        return new {$helper}();
    }
}