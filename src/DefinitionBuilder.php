<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Конфигурирует определение
 */
class DefinitionBuilder implements DefinitionBuilderInterface
{
    /**
     * @var DefinitionInterface
     */
    private $definition;

    protected function __construct(string $name)
    {
        $name = trim($name);
        if (!$name) {
            throw new DefinitionBuilderException('$name не может быть пустым');
        }

        $this->definition = new Definition();
        $this->definition->name($name);
    }

    /**
     * @inheritDoc
     */
    public static function build(string $name): DefinitionBuilderInterface
    {
        return new self($name);
    }

    /**
     * @inheritDoc
     */
    public function defineClass(string $className)
    {
        $className = trim($className);
        if (!$className) {
            throw new DefinitionBuilderException('$className не может быть пустым');
        }
        $this->definition->className($className);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDefinition(): DefinitionInterface
    {
        return $this->definition;
    }
}
