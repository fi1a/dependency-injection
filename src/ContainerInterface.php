<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Контейнер
 */
interface ContainerInterface
{
    public function __construct(ContainerConfigInterface $config);

    /**
     * Возврашщает конфиг
     */
    public function getConfig(): ContainerConfigInterface;

    /**
     * Возвращает объект на основе определения
     *
     * @return mixed
     */
    public function get(string $name);

    /**
     * Проверяет наличие определения
     */
    public function has(string $name): bool;
}
