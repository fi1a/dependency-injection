<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\Definition;
use Fi1a\DI\Exceptions\NoValidDefinitionException;
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
    public function testValidateEmpty(): void
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->validate();
    }

    /**
     * Не валидное определение
     */
    public function testValidateHasName(): void
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $definition->validate();
    }

    /**
     * Пустое имя
     */
    public function testNameEmpty(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->name('');
    }

    /**
     * Не валидное определение
     */
    public function testValidateHasClassNotHaveName(): void
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->className(ClassA::class);
        $definition->validate();
    }

    /**
     * Пустой класс
     */
    public function testClassNameEmpty(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->className('');
    }

    /**
     * Валидное определение
     */
    public function testValidateNameAndClass(): void
    {
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $definition->className(ClassA::class);
        $this->assertTrue($definition->validate());
    }

    /**
     * Валидное определение
     */
    public function testValidateConstructor(): void
    {
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $definition->className(ClassA::class);
        $definition->constructor([1, true]);
        $this->assertTrue($definition->validate());
    }

    /**
     * Имя
     */
    public function testName(): void
    {
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $this->assertEquals(ClassAInterface::class, $definition->getName());
    }

    /**
     * Класс
     */
    public function testClass(): void
    {
        $definition = new Definition();
        $definition->className(ClassA::class);
        $this->assertEquals(ClassA::class, $definition->getClassName());
    }

    /**
     * Класс
     */
    public function testConstructor(): void
    {
        $definition = new Definition();
        $definition->constructor([1, true]);
        $this->assertEquals([1, true], $definition->getConstructor());
    }

    /**
     * Свойства
     */
    public function testProperties(): void
    {
        $definition = new Definition();
        $definition->property('property1', 100)
            ->property('property2', true);
        $this->assertEquals([
            'property1' => 100,
            'property2' => true,
        ], $definition->getProperties());
        $definition->properties([]);
        $this->assertEquals([], $definition->getProperties());
        $definition->properties([
            'property1' => 100,
        ]);
        $this->assertEquals([
            'property1' => 100,
        ], $definition->getProperties());
    }

    /**
     * Свойства
     */
    public function testPropertyNameException(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->property('', null);
    }

    /**
     * Свойства
     */
    public function testPropertiesNameException(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->properties(['' => null]);
    }
}
