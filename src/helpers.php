<?php

declare(strict_types=1);

use Fi1a\DI\Container;
use Fi1a\DI\ContainerConfig;
use Fi1a\DI\ContainerInterface;

/**
 * Хелпер контейнера
 */
function di(): ContainerInterface
{
    /** @var ContainerInterface|null $container */
    static $container = null;
    if (is_null($container)) {
        $container = new Container(new ContainerConfig());
    }

    return $container;
}
