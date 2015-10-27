<?php

class Code
{


    public function accessor($property, $type)
    {
        return $type . ucfirst($property);
    }

    public function accessProp($method)
    {
        return chain($method)
            ->str_getAfterFirstUpper()
        ;
    }

    public function accessorType($method)
    {
        return chain($method)
            ->str_getBeforeFirstUpper()
        ;
    }

    public function accessorExecute($method, object $object, array &$fields, array $defaults, array $params = [])
    {
        // If the object has this method written: call that.
        if (method_exists($object, $method) === true) {
            return call_user_method_array($method, $object, $params);
        }

        // Get the property and its accessor.
        $property = $this->accessProp($method);
        $accessor = $this->accessorType($method);

        // Get the value of this property: or throw an Exception.
        $value = @$fields[$property] or throw new \Exception('Field not found: ' . $property);

        // If it's a getter or setter: they work for arrays too.
        if ($accessor === 'get') {
            return $value;
        }
        elseif ($accessor === 'set') {
            $fields[$property] = $params[0];
        }
        elseif ($accessor === 'reset') {
            $fields[$property] = $defaults[$property];
        }

        // If the value is an array: we need to process that differently.
        if (is_array($value) === true) {
            $value = chain($value)->arr_accessorExecute($method, $params);

            // If this is a chaining method: return the object.
            if (in_array($accessor, ['add', 'addElement', 'remove', 'removeElement', 'clear']) === true) {
                return $object;
            }

            return $value;
        }
        // Scalar values "is" and "has" both do the same thing.
        elseif ($accessor === 'is' || $accessor === 'has') {
            return (bool) $value;
        }

        // No accessor found: throw exception.
        throw new \Exception('Unknown accessor field method: ' . $accessor);
    }

    public function camelToUnderscore($var)
    {
        return str($var)
            ->explodeUpper()
            ->arr_each('lcfirst')
            ->implode('_')
        ;
    }

    public function underscoreToCamel($var)
    {
        return str($var)
            ->str_replace('_', ' ')
            ->ucwords()
            ->remove(' ')
            ->get()
        ;
    }

    public function pathIsClass($var, $srcDir = null)
    {
        return chain($var)
            ->is_fileOrFalse()
            ->str_removeBeginning($srcDir)
            ->str_prepend('\\')
            ->file_removeExtension()
            ->class_exists()
        ;
    }

    public function getMethods($var, $flags = null)
    {
        $refl = new ReflectionClass($var);

        return $refl->getMethods($flags);
    }

    public function getMethodsPublic($var, $static = null)
    {
        $flags = ReflectionMethod::IS_PUBLIC;

        if ($static === true) {
            $flags = ReflectionMethod::IS_STATIC & $flags;
        }
        elseif ($static === false) {
            $flags = ReflectionMethod::IS_STATIC & $flags;
        }

        return $this->getMethods($var, $flags);
    }

    public function getParameterCount(ReflectionMethod $var)
    {
        $params = $var->getParameters();

        return count($params);
    }
}
