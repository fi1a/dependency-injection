<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI\Fixtures;

class ClassC implements ClassCInterface
{
    public function __construct(int $parameter1, bool $parameter2, ClassA $classA, ?string $parameter3)
    {
    }
}
