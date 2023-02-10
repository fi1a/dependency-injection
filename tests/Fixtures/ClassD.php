<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI\Fixtures;

class ClassD implements ClassDInterface
{
    public function __construct(ClassAInterface $classA, ?bool $parameter1 = null)
    {
    }
}
