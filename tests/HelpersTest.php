<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\ContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Хелперы
 */
class HelpersTest extends TestCase
{
    /**
     * Хелпер контейнера
     */
    public function testDi(): void
    {
        $this->assertInstanceOf(ContainerInterface::class, di());
        $this->assertEquals(di(), di());
    }
}
