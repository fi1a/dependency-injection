<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Конфигурирует определение из массива
 */
class ArrayBuilder extends Builder implements ArrayBuilderInterface
{
    /**
     * @inheritDoc
     */
    public static function buildFromArray(array $definition)
    {
        $builder = static::build(
            isset($definition['name']) && is_string($definition['name']) ? $definition['name'] : ''
        );

        if (isset($definition['class_name']) && is_string($definition['class_name'])) {
            $builder->defineClass($definition['class_name']);
        }
        if (isset($definition['constructor']) && is_array($definition['constructor'])) {
            $builder->defineConstructor($definition['constructor']);
        }
        if (isset($definition['properties']) && is_array($definition['properties'])) {
            $builder->defineProperties($definition['properties']);
        }
        if (isset($definition['methods']) && is_array($definition['methods'])) {
            $builder->defineMethods($definition['methods']);
        }
        if (isset($definition['factory']) && is_callable($definition['factory'])) {
            $builder->defineFactory($definition['factory']);
        }
        if (isset($definition['object']) && is_object($definition['object'])) {
            $builder->defineObject($definition['object']);
        }

        return $builder;
    }
}
