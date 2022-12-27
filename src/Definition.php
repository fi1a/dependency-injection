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

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function name(string $name): Definition
    {
        $name = trim($name);
        if (!$name) {
            throw new DefinitionBuilderException('$name не может быть пустым');
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getClassName(): ?string
    {
        return $this->className;
    }

    /**
     * @inheritDoc
     */
    public function className(string $className): Definition
    {
        $className = trim($className);
        if (!$className) {
            throw new DefinitionBuilderException('$className не может быть пустым');
        }

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
