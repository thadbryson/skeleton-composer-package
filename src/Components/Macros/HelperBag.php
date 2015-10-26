<?php

class HelperBag
{
    protected $default = 'general';

    protected $object, $method;

    protected $elements = [];



    public function get($code)
    {
        if (isset($this->elements[$code]) === false) {
            return false;
        }

        return $this->elements[$code];
    }

    public function add(Helper $helper, $code = null)
    {
        // Use default code if one isn't set.
        if ($code === null) {
            $code = chain($code)->basename()->strtolower();
        }

        $this->elements[$code] = $helper;

        return $this;
    }

    public function parse($action)
    {
        $code   = str($action)->replace(':', '_', 1)->before('_', 1);
        $method = str($action)->replace(':', '_', 1)->after('_', 1);

        $object = $this->get($code);

        // If there is no object found: try the default.
        if ($object === false) {
            $method = $action;
            $object = $this->get($this->default);
        }

        // Verify existance.
        if ($object instanceof Helper === true && method_exists($object, $method) === true) {
            $this->object = $object;
            $this->method = $method;

            return true;
        }

        return false;
    }

    public function run(array $params)
    {
        return call_user_method_array($this->method, $this->object, $params);
    }
}
