<?php

namespace AnonPain\Macros;

class Chain extends Filter
{
    protected $var;

    protected $start;



    public function __construct($var)
    {
        $this->var   = $var;
        $this->start = clone $var;
    }

    public function get()
    {
        return $this->var;
    }

    public function reset()
    {
        $this->var = $start;

        return $this;
    }

    public function __call($method, array $params)
    {
        // Add variable to beginning of parameter list.
        array_unshift($params, $this->get());

        // Set the new altered variable.
        $this->var = parent::__call($method, $params);

        // Be sure to enable method chaining.
        // It wouldn't be a chain without it ;-)
        return $this;
    }

    public function __toString()
    {
        return $this->get();
    }
}
