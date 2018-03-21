<?php

namespace App\Helper;

class Hydrator
{
    private $refClassMap;

    public function hydrate($class, array $data)
    {
        $ref = $this->getReflectionClass($class);
        $object = $ref->newInstanceWithoutConstructor();
        foreach ($data as $name => $value) {
            $property = $ref->getProperty($name);
            if ($property->isPrivate() || $property->isProtected()) {
                $property->setAccessible(true);
            }
            $property->setValue($object, $value);
        }

        return $object;
    }

    private function getReflectionClass($className): \ReflectionClass
    {
        if (!isset($this->refClassMap[$className])) {
            $this->refClassMap[$className] = new \ReflectionClass($className);
        }
        return $this->refClassMap[$className];
    }
}