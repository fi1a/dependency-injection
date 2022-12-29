<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\ArrayBuilder;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\ClassB;
use PHPUnit\Framework\TestCase;

/**
 * Конфигурирует определение из массива
 */
class ArrayBuilderTest extends TestCase
{
    /**
     * Конфигурирует определение из массива
     */
    public function testBuildFromArrayClassName(): void
    {
        $definition = ArrayBuilder::buildFromArray([
            'name' => ClassAInterface::class,
            'class_name' => ClassA::class,
            'constructor' => [100, true],
            'properties' => [
                'property1' => 100,
                'property2' => true,
            ],
            'methods' => [
                'setProperty1' => [100],
                'setProperty2' => [true],
            ],
        ])->getDefinition();
        $this->assertEquals(ClassAInterface::class, $definition->getName());
        $this->assertEquals(ClassA::class, $definition->getClassName());
        $this->assertEquals([100, true], $definition->getConstructor());
        $this->assertEquals(
            [
                'property1' => 100,
                'property2' => true,
            ],
            $definition->getProperties()
        );
        $this->assertEquals(
            [
                'setProperty1' => [100],
                'setProperty2' => [true],
            ],
            $definition->getMethods()
        );
    }

    /**
     * Конфигурирует определение из массива
     */
    public function testBuildFromArrayFactory(): void
    {
        $function = function () {
        };
        $definition = ArrayBuilder::buildFromArray([
            'name' => ClassAInterface::class,
            'factory' => $function,
        ])->getDefinition();
        $this->assertEquals(ClassAInterface::class, $definition->getName());
        $this->assertEquals($function, $definition->getFactory());
    }

    /**
     * Конфигурирует определение из массива
     */
    public function testBuildFromArrayObject(): void
    {
        $object = new ClassA(new ClassB());
        $definition = ArrayBuilder::buildFromArray([
            'name' => ClassAInterface::class,
            'object' => $object,
        ])->getDefinition();
        $this->assertEquals(ClassAInterface::class, $definition->getName());
        $this->assertEquals($object, $definition->getObject());
    }
}
