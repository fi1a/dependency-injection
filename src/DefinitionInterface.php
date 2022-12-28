<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Определение
 */
interface DefinitionInterface
{
    /**
     * Возвращает имя
     */
    public function getName(): ?string;

    /**
     * Устанавливает имя
     *
     * @return $this
     */
    public function name(string $name);

    /**
     * Возвращает название класса
     */
    public function getClassName(): ?string;

    /**
     * Устанавливает название класса
     *
     * @return $this
     */
    public function className(string $className);

    /**
     * Параметры конструктора
     *
     * @return mixed[]|null
     */
    public function getConstructor(): ?array;

    /**
     * Параметры конструктора
     *
     * @return $this
     */
    public function constructor(?array $constructor);

    /**
     * Возвращает свойства
     *
     * @return mixed[]
     */
    public function getProperties(): array;

    /**
     * Добавляет свойство
     *
     * @param mixed $value
     *
     * @return $this
     */
    public function property(string $name, $value);

    /**
     * Устаналивает свойства
     *
     * @param mixed[] $properties
     *
     * @return $this
     */
    public function properties(array $properties);

    /**
     * Устанавливает метод, который необходимо вызвать
     *
     * @param mixed[]  $parameters
     *
     * @return $this
     */
    public function method(string $name, array $parameters = []);

    /**
     * Устанавливает методы, которые необходимо вызвать
     *
     * @param mixed[]  $methods
     *
     * @return $this
     */
    public function methods(array $methods);

    /**
     * Возвращает методы, которые необходимо вызвать
     *
     * @return mixed[]
     */
    public function getMethods(): array;

    /**
     * Устанавливает фабричный метод
     *
     * @param callable|\Closure|null $closure
     *
     * @return $this
     */
    public function factory($closure);

    /**
     * Возвращает фабричный метод
     *
     * @return callable|\Closure|null
     */
    public function getFactory();

    /**
     * Устанавливает объект
     *
     * @return $this
     */
    public function object(?object $object);

    /**
     * Возвращает объект
     */
    public function getObject(): ?object;

    /**
     * Осуществляет валидацию определения
     */
    public function validate(): bool;
}
