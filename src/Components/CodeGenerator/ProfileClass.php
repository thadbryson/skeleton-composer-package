<?php

namespace AnonPain\Components\CodeGenerator;

class ProfileCode
{


    public function readFile($path)
    {
        $path = chain($path)
            ->is_fileOrFail('File not found: ' . $path)
            ->code_fileToFullName()
        ;
    }

    public function readObject(object $obj)
    {
        $reflection = new \ReflectionClass($obj);

        $profile = [
            'namespace'  => $reflection->getNamespaceName(),
            'filepath'   => $reflection->getFileName(),
            'properties' => $this->readParameters($reflection->getProperties()),
            'methods'    => $this->readMethods($reflection->getMethods()),
        ];

        return $this->addModifiers($profile, $reflection);
    }

    public function readMethods(array $methods)
    {
        return chain($methods)
            ->arr_collect(function (array $var, $collection, $key, $value) {

                $collection[$value->getName()] = [
                    'constructor'         => $value->isConstructor(),
                    'destructor'          => $value->isDestructor(),
                    'params'              => $this->readParameters($value->getProperties()),
                    'paramsCount'         => $value->getNumberOfParameters(),
                    'paramsRequiredCount' => $value->getNumberOfRequiredParameters(),
                ];

                $this->addModifiers($collection, $value);
            })
        ;
    }

    public function readParameters(array $params)
    {
        return chain($params)
            ->arr_collect(function (array $var, $collection, $key, $value) {

                $collection[$value->getName()] = [
                    'default'    => $value->getDefaultValue(),
                    'position'   => $value->getPosition(),
                ];

                $this->addModifiers($collection, $value);
            })
        ;
    }

    public function addModifiers(array $profile, $value)
    {
        $profile['name']    = $value->getName();
        $profile['comment'] = $value->getDocComment();

        if ($value->isPrivate() === true) {
            $profile['visibility'] = 'private';
        }
        elseif ($value->isProtected() === true) {
            $profile['visibility'] = 'protected';
        }
        elseif ($value->isPublic() === true) {
            $profile['visibility'] = 'public';
        }

        $profile['final']    = $value->isFinal();
        $profile['abstract'] = $value->isAbstract();
        $profile['static']   = $value->isStatic();

        return $profile;
    }
}
