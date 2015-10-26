<?php

class FunctionBag
{
    protected $functionName = false;

    /**
     * @var array
     *
     * Global function exceptions where the variable is
     * NOT the first parameter.
     */
    protected static $nonStandard = [
        'str_replace' => 3,
    ];

    protected static $banned = [];



    public static function isStandard($functionName)
    {
        return isset(self::$nonStandard[$functionName]) === false;
    }

    public static function getVarPosition($functionName)
    {
        return arr(self::$nonStandard)->search($functionName, 0);
    }

    public static function isBanned($functionName)
    {
        return arr(self::$banned)->search($functionName, false);
    }

    public static function runnable($functionName)
    {
        return function_exists($functionName) === true && self::isBanned($functionName) === false;
    }

    public static function parse($action)
    {
        if (self::runnable($action) === false) {
            return false;
        }

        $position = self::getVarPosition($action);

        $this->functionName = $action;

        return true;
    }

    public function run(array $params)
    {
        if (self::runnable($this->functionName) === false) {
            return;
        }

        $position = $this->getVarPosition($functionName);

        $params = arr($params)->swap($position, 0);

        return call_user_func_array($this->functionName, $params);
    }
}