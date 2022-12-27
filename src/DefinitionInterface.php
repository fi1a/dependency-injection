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
    public function name(?string $name);

    /**
     * Возвращает название класса
     */
    public function getClassName(): ?string;

    /**
     * Устанавливает название класса
     *
     * @return $this
     */
    public function className(?string $className);

    /**
     * Осуществляет валидацию определения
     */
    public function validate(): bool;
}
