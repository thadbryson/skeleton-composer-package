<?php

class Register
{
    protected $srcDir;

    protected $manager;

    protected $registerMethod;

    protected $restriction;



    public function __construct($srcDir, object $manager = null, $registerMethod = null)
    {
        $this->srcDir = chain($srcDir)
            ->rtrim('/')
            ->is_dirOrFail('\$src directory does not exist: :var')
            ->realpath()
            ->get()
        ;

        $this->setManager($manager, $registerMethod);
    }

    public function setManager(object $manager, $registerMethod)
    {
        $noMethodMessage  = sprintf('Method "%s" not found on class: $s',      $registerMethod, get_class($manager));
        $notPublicMessage = sprintf('Method "%s" on class "%s" is not public', $registerMethod, get_class($manager));

        chain($manager)
            ->method_existsOrFail($registerMethod, $noMethodMessage)
            ->obj_isCallableOrFail($registerMethod, true, $notPublicMessage)
        ;

        $this->manager        = $manager;
        $this->registerMethod = $registerMethod;

        return $this;
    }

    public function setRestriction($restriction)
    {
        $this->restriction = chain($restriction)
            ->ltrim('\\')
            ->str_concatBefore('\\')
            ->class_existsOrFail('Restriction object does not exist: :var')
            ->get()
        ;

        return $this;
    }

    public function find($pattern, $namespace = null)
    {
        return chain($pattern)
            ->ltrim('/')
            ->str_concatBefore($this->srcDir . '/')
            ->glob()
            ->arr_eachRun('file_removeExt')
            ->arr_eachRun('str_after', [$this->srcDir])
            ->arr_remove(function ($array, $key, $value, $objectCalling) use ($namespace) {

                if (is_string($namespace) === true && strlen($namespace) > 0) {
                    $value = $namespace . '\\' . $value;
                }

                // Does class exist: autoload by deafult "true"
                return class_exists('\\' . $value, true) === false;
            })
            ->arr_each(function ($array, $key, $value, $objectCalling) {

                return new {$value}();
            })
            ->get()
        ;
    }

    public function findAndLoad($pattern, $namespace = null)
    {
        foreach ($this->find($pattern, $namespace) as $object) {

            $this->load($object);
        }

        return $this;
    }

    public function isRestricted($object)
    {
        // If no restruction: return false.
        if ($this->restriction === null) {
            return false;
        }

        return $object instanceof $this->restriction === false;
    }

    public function load($object, array $params = [])
    {
        // Convert to a Object if it's a string.
        $object = chain($object)->code_toObject();

        return $this->manager->{$this->registerMethod}($object);
    }
}