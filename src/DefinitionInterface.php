<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Определение
 */
interface DefinitionInterface
{
    /**
     * Осуществляет валидацию определения
     */
    public function validate(): bool;
}
