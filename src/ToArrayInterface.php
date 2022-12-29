<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Преобразование коллекции или определения в массив
 */
interface ToArrayInterface
{
    /**
     * Коллекцию в массив
     *
     * @return mixed[][]
     */
    public function collection(DefinitionCollectionInterface $collection): array;

    /**
     * Определение в массив
     *
     * @return mixed[]
     */
    public function definition(DefinitionInterface $definition): array;
}
