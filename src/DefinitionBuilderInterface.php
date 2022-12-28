<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Конфигурирует определение
 */
interface DefinitionBuilderInterface
{
    /**
     * Фабричный метод
     */
    public static function build(string $name): DefinitionBuilderInterface;

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
     * Определяет вызываемый метод
     *
     * @param mixed[]  $parameters
     *
     * @return $this
     */
    public function defineMethod(string $name, array $parameters = []);

    /**
     * Возвращает определение
     */
    public function getDefinition(): DefinitionInterface;
}
