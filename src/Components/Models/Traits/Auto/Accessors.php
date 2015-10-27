<?php

trait Accessors
{


    public function magicCallAccessors($method, array $params)
    {
        return chain($method)
            ->code_accessorRun($this->fields, $params)
        ;
    }
}
