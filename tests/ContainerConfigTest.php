<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\ContainerConfig;
use Fi1a\DI\ContainerConfigInterface;
use Fi1a\DI\DefinitionBuilder;
use Fi1a\DI\Exceptions\NoValidDefinitionException;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use PHPUnit\Framework\TestCase;

/**
 * Конфиг контейнера
 */
class ContainerConfigTest extends TestCase
{
    /**
     * Возвращает конфиг контейнера
     */
    private function getContainerConfig(): ContainerConfigInterface
    {
        return new ContainerConfig();
    }

    /**
     * Определения
     */
    public function testDefinition(): void
    {
        $containerConfig = $this->getContainerConfig();
        $containerConfig->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
            ->defineClass(ClassA::class)
            ->getDefinition()
        );
        $this->assertCount(1, $containerConfig->getDefinitions());
    }

    /**
     * Определения
     */
    public function testDefinitionValidate(): void
    {
        $this->expectException(NoValidDefinitionException::class);
        $containerConfig = $this->getContainerConfig();
        $containerConfig->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->getDefinition()
        );
    }
}
