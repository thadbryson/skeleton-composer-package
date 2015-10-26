<?php

class CallbackBag
{
    protected $elements = [];

    protected $action = false;



    public function add($name, Callback $callback)
    {
        $this->elements[$name] = $callback;

        return $this
    }

    public static function parse($action)
    {
        if (isset($this->elements[$action]) === true) {
            return false;
        }

        $this->action = $this->elements[$action];

        return true;
    }

    public function run(array $params)
    {
        if ($this->action === false) {
            return;
        }

        return call_user_func_array($this->action, $params);
    }
}