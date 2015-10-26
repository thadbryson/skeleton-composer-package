<?php

class Filter
{
    protected $postModifierBag;

    protected $helperBag;

    protected $functionBag;

    protected $callbackBag;



    public function __call($action, array $params)
    {
        $result = $this->getBag($action)->run($params);

        $modify = $this->getPostModifierBag();

        // Run the modifier if we have one.
        if ($modify->parse($action, $params) === true) {

            array_unshift($params, $result);

            $result = $modify->run($params);
        }

        return $result;
    }

    protected function getBag($action)
    {
        if ($this->getCallbackBag()->parse($action) === true) {

            return $this->getCallbackBag();
        }
        elseif ($this->getHelperBag()->parse($action) === true) {

            return $this->getHelperBag();
        }
        elseif ($this->getFunctionBag()->parse($action) === true) {

            return $this->getFunctionBag();
        }

        // Could not find an action: throw exception.
        throw new Exception('Chain action invalid: ' . $this->action);
    }

    public function getPostModifiers()
    {
        // Init one if there isn't one already.
        // Default configuration.
        if ($this->postModifierBag === null) {
            $modify = new PostModifierBag();
            $modify->addStandard();

            $this->setPostModifiers($modify);
        }

        return $this->postModifierBag;
    }

    public function setPostModifiers(PostModifierBag $postModifierBag)
    {
        $this->postModifierBag = $postModifierBag;

        return $this;
    }

    public function getHelperBag()
    {
        return $this->helperBag;
    }

    public function setHelperBag(HelperBag $helperBag)
    {
        $this->helperBag = $helperBag;

        return $this;
    }

    public function getFunctionBag()
    {
        // Init one if there isn't one already.
        // Default configuration.
        if ($this->functionBag === null) {
            $this->setFunctionBag(new FunctionBag());
        }

        return $this->functionBag;
    }

    public function setFunctionBag(FunctionBag $functionBag)
    {
        $this->functionBag = $functionBag;

        return $this;
    }

    public function getCallbackBag()
    {
        // Init one if there isn't one already.
        // Default configuration.
        if ($this->callbackBag === null) {
            $this->setCallbackBag(new CallbackBag());
        }

        return $this->callbackBag;
    }

    public function setCallbackBag(CallbackBag $callbackBag)
    {
        $this->callbackBag = $callbackBag;

        return $this;
    }
}