<?php

declare(strict_types=1);

namespace Fi1a\DI;

use Fi1a\Hydrator\HydratorInterface;

/**
 * Контейнер
 */
interface ContainerInterface
{
    public function __construct(ContainerConfigInterface $config, ?HydratorInterface $hydrator = null);

    /**
     * Возврашщает конфиг
     */
    public function config(): ContainerConfigInterface;

    /**
     * Возвращает объект на основе определения
     */
    public function get(string $name): object;

    /**
     * Проверяет наличие определения
     */
    public function has(string $name): bool;
}
