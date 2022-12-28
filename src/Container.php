<?php

declare(strict_types=1);

namespace Fi1a\DI;

use Fi1a\DI\Exceptions\NotFoundException;
use Fi1a\Hydrator\Hydrator;
use Fi1a\Hydrator\HydratorInterface;
use ReflectionClass;

/**
 * Контейнер
 */
class Container implements ContainerInterface
{
    /**
     * @var ContainerConfigInterface
     */
    private $config;

    /**
     * @var HydratorInterface
     */
    private $hydrator;

    public function __construct(ContainerConfigInterface $config, ?HydratorInterface $hydrator = null)
    {
        $this->config = $config;
        if (is_null($hydrator)) {
            $hydrator = new Hydrator();
        }
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritDoc
     */
    public function config(): ContainerConfigInterface
    {
        return $this->config;
    }

    /**
     * @inheritDoc
     */
    public function get(string $name): object
    {
        $definition = null;
        if (!$this->config->getDefinitions()->has($name)) {
            if (!class_exists($name)) {
                throw new NotFoundException(sprintf('Не удалось создать объект для "%s"', $name));
            }
            $reflection = new ReflectionClass($name);
            if ($reflection->isAbstract() || $reflection->isInterface()) {
                throw new NotFoundException(sprintf('Не удалось создать объект для "%s"', $name));
            }
            $definition = DefinitionBuilder::build($name)
                ->defineClass($name)
                ->getDefinition();
        }
        if (!$definition) {
            /** @var DefinitionInterface $definition */
            $definition = $this->config->getDefinitions()->get($name);
        }
        assert($definition instanceof DefinitionInterface);

        return $this->factory($definition);
    }

    /**
     * @inheritDoc
     */
    public function has(string $name): bool
    {
        return $this->config->getDefinitions()->has($name);
    }

    /**
     * Создает объект по определению
     */
    private function factory(DefinitionInterface $definition): object
    {
        $instance = null;
        if ($definition->getClassName()) {
            $instance = $this->factoryByClassName($definition);
        }
        assert(is_object($instance));
        if (count($definition->getProperties())) {
            $this->setPropertiesToInstance($definition->getProperties(), $instance);
        }
        if (count($definition->getMethods())) {
            $this->callMethodsInInstance($definition->getMethods(), $instance);
        }

        return $instance;
    }

    /**
     * Вызвать методы у объекта
     *
     * @param mixed[]  $methods
     */
    private function callMethodsInInstance(array $methods, object $instance): void
    {
        /** @var mixed[] $parameters */
        foreach ($methods as $method => $parameters) {
            call_user_func_array([$instance, (string) $method], $parameters);
        }
    }

    /**
     * Установить свойства объекту
     *
     * @param mixed[] $properties
     */
    private function setPropertiesToInstance(array $properties, object $instance): void
    {
        $this->hydrator->hydrateModel($properties, $instance);
    }

    /**
     * Создает объект по классу
     */
    private function factoryByClassName(DefinitionInterface $definition): object
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         * @psalm-suppress ArgumentTypeCoercion
         */
        $reflection = new ReflectionClass($definition->getClassName());
        $constructor = $reflection->getConstructor();
        $constructorParameters = $definition->getConstructor();
        /** @var mixed[] $parameters */
        $parameters = [];
        if ($constructor) {
            foreach ($constructor->getParameters() as $index => $parameter) {
                $type = $parameter->getType();
                /** @psalm-suppress UndefinedMethod */
                $parameterTypeName = $type ? (string) $type->getName() : null;
                $value = null;
                if ($parameter->isDefaultValueAvailable()) {
                    /** @var mixed $value */
                    $value = $parameter->getDefaultValue();
                }
                if (is_array($constructorParameters) && isset($constructorParameters[$parameter->getName()])) {
                    /** @var mixed $value */
                    $value = $constructorParameters[$parameter->getName()];
                } elseif ($parameterTypeName && class_exists($parameterTypeName)) {
                    $value = $this->get($parameterTypeName);
                } elseif (is_array($constructorParameters) && isset($constructorParameters[$index])) {
                    /** @var mixed $value */
                    $value = $constructorParameters[$index];
                }

                /** @psalm-suppress MixedAssignment */
                $parameters[] = $value;
            }
        }

        return $reflection->newInstance(...$parameters);
    }
}
