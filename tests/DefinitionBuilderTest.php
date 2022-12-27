<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\DefinitionBuilder;
use Fi1a\DI\DefinitionBuilderInterface;
use Fi1a\DI\DefinitionInterface;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use PHPUnit\Framework\TestCase;

/**
 * Конфигурирует определение
 */
class DefinitionBuilderTest extends TestCase
{
    /**
     * Фабричный метод
     */
    public function testBuild()
    {
        $this->assertInstanceOf(
            DefinitionBuilderInterface::class,
            DefinitionBuilder::build(ClassAInterface::class)
        );
    }

    /**
     * Определить класс
     */
    public function testDefineClass()
    {
        $definition = DefinitionBuilder::build(ClassAInterface::class)
            ->defineClass(ClassA::class)
            ->getDefinition();

        $this->assertInstanceOf(DefinitionInterface::class, $definition);
        $this->assertEquals(ClassAInterface::class, $definition->getName());
        $this->assertEquals(ClassA::class, $definition->getClassName());
    }
}
