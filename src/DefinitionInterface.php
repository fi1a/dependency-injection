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
     * Осуществляет валидацию определения
     */
    public function validate(): bool;
}
