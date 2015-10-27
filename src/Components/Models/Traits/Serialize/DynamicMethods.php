<?php

trait DynamicMethods
{
    protected $dynamicMethods = [];



    public function addMethod($name, Callback $method)
    {
        $this->dynamicMethods[$name] = $method;

        return $this;
    }

    public function removeMethod($name)
    {
        unset($this->dynamicMethods[$name]);

        return $this;
    }
}
