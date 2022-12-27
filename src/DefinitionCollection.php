<?php

declare(strict_types=1);

namespace Fi1a\DI;

use Fi1a\Collection\Collection;

/**
 * Коллекция определений
 */
class DefinitionCollection extends Collection implements DefinitionCollectionInterface
{
    public function __construct(?array $data = null)
    {
        parent::__construct(DefinitionInterface::class, $data);
    }
}
