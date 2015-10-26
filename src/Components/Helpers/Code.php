<?php

class Code
{


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
