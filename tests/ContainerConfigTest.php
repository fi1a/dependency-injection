<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\ContainerConfig;
use Fi1a\DI\ContainerConfigInterface;
use Fi1a\DI\Definition;
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
    public function testDefinition()
    {
        $containerConfig = $this->getContainerConfig();
        $containerConfig->addDefinition(new Definition());
        $this->assertCount(1, $containerConfig->getDefinitions());
    }
}
