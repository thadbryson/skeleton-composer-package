<?php

class PostModifierBag
{
    protected $elements = [];

    protected $post, $paramCount;



    public function run(array $params)
    {
        // If no post modifier: return result.
        if ($this->post === null) {
            return $result;
        }

        $result = array_shift($params);
        $var    = array_shift($params);

        $postParams = arr($params)->getLastNumElements($this->paramCount);
        $params     = arr($params)->removeLastNumElements($this->paramCount);

        $params = array_merge($result, $var, [$params], $postParams);

        return call_user_func_array($this->post, $params);
    }

    public function parse($action, array &$params)
    {
        $this->post       = null;
        $this->postParams = null;

        foreach ($this->elements as $code => $post) {

            $code = ucfirst($code);

            if (str($action)->endsWith($code) === true) {
                $paramCount = $post[0];
                $this->post       = $post[1];

                $this->postParams = arr($params)->getLastNumElements($post);
                $params           = arr($params)->removeLastNumElements($post);

                return true;
            }
        }

        return false;
    }

    public function add($code, $numParams, Callback $callback)
    {
        $this->elements[$code] = [$numParams, $callback];

        return $this;
    }

    public function addStandard()
    {
        $this->add('OrFail', 1, function ($result, $var, array $params, $message) {

            $message = str_replace([':var', ':result'], [$var, $result], $message);

            return new \Exception($message);
        });

        $this->add('Or', 1, function ($result, $var, array $params, $default) {

            if (empty($result)) {
                return $default;
            }

            return $result;
        });

        $this->add('OrRollback', 0, function ($result, array $params, $var) {

            if (empty($result)) {
                return $var;
            }

            return $result;
        });

        return $this;
    }
}