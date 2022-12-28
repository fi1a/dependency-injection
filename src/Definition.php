<?php

declare(strict_types=1);

namespace Fi1a\DI;

use Fi1a\DI\Exceptions\NoValidDefinitionException;

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
     * @var mixed[]|null
     */
    private $constructor;

    /**
     * @var mixed[]
     */
    private $properties = [];

    /**
     * @var mixed[]
     */
    private $methods = [];

    /**
     * @var callable|\Closure|null
     */
    private $factory;

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
            throw new NoValidDefinitionException('$name не может быть пустым');
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
    public function className(?string $className): Definition
    {
        if (!is_null($className)) {
            $className = trim($className);
            if (!$className) {
                throw new NoValidDefinitionException('$className не может быть пустым');
            }
        }

        $this->className = $className;
        $this->factory = null;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConstructor(): ?array
    {
        return $this->constructor;
    }

    /**
     * @inheritDoc
     */
    public function constructor(?array $constructor)
    {
        $this->constructor = $constructor;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @inheritDoc
     */
    public function property(string $name, $value)
    {
        $name = trim($name);
        if (!$name) {
            throw new NoValidDefinitionException('$name не может быть пустым');
        }

        $this->properties[$name] = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function properties(array $properties)
    {
        $this->properties = [];
        /** @var mixed $value */
        foreach ($properties as $name => $value) {
            $this->property((string) $name, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function method(string $name, array $parameters = [])
    {
        $name = trim($name);
        if (!$name) {
            throw new NoValidDefinitionException('$name не может быть пустым');
        }

        $this->methods[$name] = $parameters;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function methods(array $methods)
    {
        $this->methods = [];
        /** @var mixed $value */
        foreach ($methods as $name => $value) {
            $this->method((string) $name, (array) $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @inheritDoc
     */
    public function factory($closure)
    {
        if (!is_callable($closure)) {
            throw new NoValidDefinitionException('Ошибка в типе $closure');
        }
        $this->factory = $closure;
        $this->className = null;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @inheritDoc
     */
    public function validate(): bool
    {
        if (!$this->name) {
            throw new NoValidDefinitionException('Обязательный параметр name не задан');
        }
        if (!$this->className && !$this->factory) {
            throw new NoValidDefinitionException(
                'Не задан один из обязательных параметров (className, factory)'
            );
        }

        return true;
    }
}
