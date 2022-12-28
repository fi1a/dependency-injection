<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI\Fixtures;

class ClassA extends AbstractClassA
{
    public $property1;

    public $property2;

    public function __construct(ClassB $classB, int $parameter1 = 1)
    {
    }

    public function setProperty1(int $value)
    {
        $this->property1 = $value;
    }

    public function setProperty2(bool $value)
    {
        $this->property2 = $value;
    }
}
