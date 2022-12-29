<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Преобразование коллекции или определения в массив
 */
class ToArray implements ToArrayInterface
{
    /**
     * @inheritDoc
     */
    public function collection(DefinitionCollectionInterface $collection): array
    {
        $result = [];
        foreach ($collection as $definition) {
            assert($definition instanceof DefinitionInterface);
            $result[] = $this->definition($definition);
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function definition(DefinitionInterface $definition): array
    {
        $definition->validate();
        /** @var mixed[] $result */
        $result = [
            'name' => $definition->getName(),
        ];
        if ($definition->getClassName()) {
            $result['class_name'] = $definition->getClassName();
        }
        if ($definition->getConstructor()) {
            $result['constructor'] = $definition->getConstructor();
        }
        if (count($definition->getProperties())) {
            $result['properties'] = $definition->getProperties();
        }
        if (count($definition->getMethods())) {
            $result['methods'] = $definition->getMethods();
        }
        if ($definition->getFactory()) {
            $result['factory'] = $definition->getFactory();
        }
        if ($definition->getObject()) {
            $result['object'] = $definition->getObject();
        }

        return $result;
    }
}
