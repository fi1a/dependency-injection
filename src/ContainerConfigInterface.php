<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Конфиг контейнера
 */
interface ContainerConfigInterface
{
    /**
     * Добавить сконфигуриров
     *
     * @return $this
     */
    public function addDefinition(DefinitionInterface $definition);
}
