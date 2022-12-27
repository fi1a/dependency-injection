<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\Definition;
use Fi1a\DI\DefinitionBuilderException;
use Fi1a\DI\NoValidDefinitionException;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
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
        $definition->name(ClassAInterface::class);
        $definition->validate();
    }

    /**
     * Пустое имя
     */
    public function testNameEmpty()
    {
        $this->expectException(DefinitionBuilderException::class);

        $definition = new Definition();
        $definition->name('');
    }

    /**
     * Не валидное определение
     */
    public function testValidateHasClassNotHaveName()
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->className(ClassA::class);
        $definition->validate();
    }

    /**
     * Пустой класс
     */
    public function testClassNameEmpty()
    {
        $this->expectException(DefinitionBuilderException::class);

        $definition = new Definition();
        $definition->className('');
    }

    /**
     * Не валидное определение
     */
    public function testValidateNameAndClass()
    {
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $definition->className(ClassA::class);
        $this->assertTrue($definition->validate());
    }
}
