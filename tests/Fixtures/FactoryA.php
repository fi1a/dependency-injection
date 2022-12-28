<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI\Fixtures;

class FactoryA
{
    public function factory(ClassB $classB, int $parameter1 = 100): ClassAInterface
    {
        return static::factoryStatic($classB, $parameter1);
    }

    public static function factoryStatic(ClassB $classB, int $parameter1 = 100): ClassAInterface
    {
        $instance = new ClassA($classB);
        $instance->property1 = $parameter1;
        $instance->property2 = true;

        return $instance;
    }
}
