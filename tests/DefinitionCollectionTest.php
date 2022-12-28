<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\Definition;
use Fi1a\DI\DefinitionCollection;
use PHPUnit\Framework\TestCase;

/**
 * Коллекция определений
 */
class DefinitionCollectionTest extends TestCase
{
    /**
     * Коллекция определений
     */
    public function testConstruct(): void
    {
        $collection = new DefinitionCollection();
        $collection[] = new Definition();
        $this->assertCount(1, $collection);
    }

    /**
     * Коллекция определений
     */
    public function testTypeException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $collection = new DefinitionCollection();
        $collection[] = $this;
    }
}
