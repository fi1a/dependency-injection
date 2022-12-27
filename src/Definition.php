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
    private $name;

    /**
     * @var string|null
     */
    private $className;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function name(?string $name): Definition
    {
        $this->name = $name;

        return $this;
    }

    public function getClassName(): ?string
    {
        return $this->className;
    }

    public function className(?string $className): Definition
    {
        $this->className = $className;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function validate(): bool
    {
        if (!$this->name) {
            throw new NoValidDefinitionException('Обязательный параметр name не задан');
        }
        if (!$this->className) {
            throw new NoValidDefinitionException('Обязательный параметр className не задан');
        }

        return true;
    }
}
