<?php

declare(strict_types=1);

namespace Fi1a\DI;

/**
 * Конфиг контейнера
 */
class ContainerConfig implements ContainerConfigInterface
{
    /**
     * @var DefinitionCollectionInterface
     */
    private $definitions;

    public function __construct()
    {
        $this->definitions = new DefinitionCollection();
    }

    /**
     * @inheritDoc
     */
    public function addDefinition(DefinitionInterface $definition)
    {
        $definition->validate();
        $this->definitions[(string) $definition->getName()] = $definition;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDefinitions(): DefinitionCollectionInterface
    {
        return $this->definitions;
    }
}
