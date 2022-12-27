<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\Definition;
use Fi1a\DI\NoValidDefinitionException;
use Fi1a\Unit\DI\Fixtures\ClassA;
use PHPUnit\Framework\TestCase;

/**
 * Определение
 */
class DefinitionTest extends TestCase
{
    /**
     * Не валидное определение
     */
    public function testValidateEmpty()
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->validate();
    }

    /**
     * Не валидное определение
     */
    public function testValidateHasName()
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->name = 'name';
        $definition->validate();
    }

    /**
     * Не валидное определение
     */
    public function testValidateHasClassNotHaveName()
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->class = ClassA::class;
        $definition->validate();
    }

    /**
     * Не валидное определение
     */
    public function testValidateNameAndClass()
    {
        $definition = new Definition();
        $definition->name = 'name';
        $definition->class = ClassA::class;
        $this->assertTrue($definition->validate());
    }
}
