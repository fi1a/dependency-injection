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
        $this->definition->className($className);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defineConstructor(array $constructor)
    {
        $this->definition->constructor($constructor);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defineProperty(string $name, $value)
    {
        $this->definition->property($name, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defineMethod(string $name, array $parameters = [])
    {
        $this->definition->method($name, $parameters);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function defineFactory($closure)
    {
        $this->definition->factory($closure);

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
