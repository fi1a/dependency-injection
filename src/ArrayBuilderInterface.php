<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Конфигурирует определение из массива
 */
interface ArrayBuilderInterface extends BuilderInterface
{
    /**
     * Определение из массива
     *
     * @param mixed[]|mixed[][] $definition
     *
     * @return static
     */
    public static function buildFromArray(array $definition);
}
