<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Определение
 */
class Definition implements DefinitionInterface
{
    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $class;

    /**
     * @inheritDoc
     */
    public function validate(): bool
    {
        if (!$this->name) {
            throw new NoValidDefinitionException('Обязательный параметр name');
        }
        if (!$this->class) {
            throw new NoValidDefinitionException('Обязательный параметр class');
        }

        return true;
    }
}
