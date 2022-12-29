<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\Definition;
use Fi1a\DI\DefinitionCollection;
use Fi1a\DI\ToArray;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\ClassB;
use Fi1a\Unit\DI\Fixtures\ClassBInterface;
use PHPUnit\Framework\TestCase;

/**
 * Преобразование коллекции или определения в массив
 */
class ToArrayTest extends TestCase
{
    /**
     * Коллекцию в массив
     */
    public function testCollection(): void
    {
        $collection = new DefinitionCollection();

        $collection[] = (new Definition())
            ->name(ClassAInterface::class)
            ->className(ClassA::class);
        $collection[] = (new Definition())
            ->name(ClassBInterface::class)
            ->className(ClassB::class);

        $this->assertEquals([
            [
                'name' => ClassAInterface::class,
                'class_name' => ClassA::class,
            ],
            [
                'name' => ClassBInterface::class,
                'class_name' => ClassB::class,
            ],
        ], (new ToArray())->collection($collection));
    }

    /**
     * Определение в массив
     */
    public function testDefinitionToArrayClassName(): void
    {
        $definition = (new Definition())
            ->name(ClassAInterface::class)
            ->className(ClassA::class);

        $this->assertEquals(
            [
                'name' => ClassAInterface::class,
                'class_name' => ClassA::class,
            ],
            (new ToArray())->definition($definition)
        );
    }

    /**
     * Определение в массив
     */
    public function testDefinitionToArrayClassNameFull(): void
    {
        $definition = (new Definition())
            ->name(ClassAInterface::class)
            ->className(ClassA::class)
            ->constructor([100, true])
            ->properties([
                'property1' => 100,
                'property2' => true,
            ])
            ->methods([
                'setProperty1' => [100],
                'setProperty2' => [true],
            ]);

        $this->assertEquals(
            [
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
            ],
            (new ToArray())->definition($definition)
        );
    }

    /**
     * Определение в массив
     */
    public function testDefinitionToArrayFactory(): void
    {
        $function = function () {
        };
        $definition = (new Definition())
            ->name(ClassAInterface::class)
            ->factory($function);

        $this->assertEquals(
            [
                'name' => ClassAInterface::class,
                'factory' => $function,
            ],
            (new ToArray())->definition($definition)
        );
    }

    /**
     * Определение в массив
     */
    public function testDefinitionToArrayObject(): void
    {
        $object = new ClassA(new ClassB());
        $definition = (new Definition())
            ->name(ClassAInterface::class)
            ->object($object);

        $this->assertEquals(
            [
                'name' => ClassAInterface::class,
                'object' => $object,
            ],
            (new ToArray())->definition($definition)
        );
    }
}
