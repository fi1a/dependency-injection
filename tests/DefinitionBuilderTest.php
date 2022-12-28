<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\DefinitionBuilder;
use Fi1a\DI\DefinitionBuilderInterface;
use Fi1a\DI\DefinitionInterface;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\ClassB;
use Fi1a\Unit\DI\Fixtures\ClassBInterface;
use PHPUnit\Framework\TestCase;

/**
 * Конфигурирует определение
 */
class DefinitionBuilderTest extends TestCase
{
    /**
     * Фабричный метод
     */
    public function testBuild(): void
    {
        $this->assertInstanceOf(
            DefinitionBuilderInterface::class,
            DefinitionBuilder::build(ClassAInterface::class)
        );
    }

    /**
     * Определить класс
     */
    public function testDefineClass(): void
    {
        $definition = DefinitionBuilder::build(ClassAInterface::class)
            ->defineClass(ClassA::class)
            ->getDefinition();

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertEquals(ClassAInterface::class, $definition->getName());
        $this->assertEquals(ClassA::class, $definition->getClassName());
    }

    /**
     * Определить класс
     */
    public function testDefineConstructor(): void
    {
        $definition = DefinitionBuilder::build(ClassAInterface::class)
            ->defineClass(ClassA::class)
            ->defineConstructor([1, true])
            ->getDefinition();

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertEquals(ClassAInterface::class, $definition->getName());
        $this->assertEquals(ClassA::class, $definition->getClassName());
        $this->assertEquals([1, true], $definition->getConstructor());
    }

    /**
     * Определить свойства класса
     */
    public function testDefineProperty(): void
    {
        $definition = DefinitionBuilder::build(ClassAInterface::class)
            ->defineClass(ClassA::class)
            ->defineProperty('property1', 100)
            ->defineProperty('property2', true)
            ->getDefinition();

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertEquals(ClassAInterface::class, $definition->getName());
        $this->assertEquals(ClassA::class, $definition->getClassName());
        $this->assertEquals([
            'property1' => 100,
            'property2' => true,
        ], $definition->getProperties());
    }

    /**
     * Определить вызываемый метод класса
     */
    public function testDefineMethod(): void
    {
        $definition = DefinitionBuilder::build(ClassAInterface::class)
            ->defineClass(ClassA::class)
            ->defineMethod('setProperty1', [100])
            ->defineMethod('setProperty2', [true])
            ->getDefinition();

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertEquals(ClassAInterface::class, $definition->getName());
        $this->assertEquals(ClassA::class, $definition->getClassName());
        $this->assertEquals([
            'setProperty1' => [100],
            'setProperty2' => [true],
        ], $definition->getMethods());
    }

    /**
     * Определить вызываемый метод класса
     */
    public function testDefineFactory(): void
    {
        $func = function () {
        };
        $definition = DefinitionBuilder::build(ClassAInterface::class)
            ->defineFactory($func)
            ->getDefinition();

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertEquals($func, $definition->getFactory());
    }

    /**
     * Определить объект
     */
    public function testDefineObject(): void
    {
        $object = new ClassB();
        $definition = DefinitionBuilder::build(ClassBInterface::class)
            ->defineObject($object)
            ->getDefinition();

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertEquals($object, $definition->getObject());
    }
}
