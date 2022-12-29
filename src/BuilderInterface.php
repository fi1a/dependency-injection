<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Конфигурирует определение
 */
interface BuilderInterface
{
    /**
     * Фабричный метод
     *
     * @return static
     */
    public static function build(string $name);

    /**
     * Определяет класс
     *
     * @return $this
     */
    public function defineClass(string $className);

    /**
     * Определяет параметры конструктора
     *
     * @param mixed[] $constructor
     *
     * @return $this
     */
    public function defineConstructor(array $constructor);

    /**
     * Определяет свойство, которое следует установить
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function defineProperty(string $name, $value);

    /**
     * Определяет свойства, которое следует установить
     *
     * @param mixed[] $properties
     *
     * @return $this
     */
    public function defineProperties(array $properties);

    /**
     * Определяет вызываемый метод
     *
     * @param mixed[]  $parameters
     *
     * @return $this
     */
    public function defineMethod(string $name, array $parameters = []);

    /**
     * Определяет вызываемые методы
     *
     * @param mixed[]  $methods
     *
     * @return $this
     */
    public function defineMethods(array $methods);

    /**
     * Определяет фабричный метод
     *
     * @param callable|\Closure|null $closure
     *
     * @return $this
     */
    public function defineFactory($closure);

    /**
     * Определяет объект
     *
     * @return $this
     */
    public function defineObject(object $object);

    /**
     * Возвращает определение
     */
    public function getDefinition(): DefinitionInterface;
}
