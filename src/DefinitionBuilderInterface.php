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
     * Возвращает определение
     */
    public function getDefinition(): DefinitionInterface;
}
