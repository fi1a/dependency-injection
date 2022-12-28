<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\Container;
use Fi1a\DI\ContainerConfig;
use Fi1a\DI\DefinitionBuilder;
use Fi1a\DI\Exceptions\NotFoundException;
use Fi1a\Unit\DI\Fixtures\AbstractClassA;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\ClassB;
use Fi1a\Unit\DI\Fixtures\ClassBInterface;
use Fi1a\Unit\DI\Fixtures\ClassC;
use Fi1a\Unit\DI\Fixtures\ClassCInterface;
use Fi1a\Unit\DI\Fixtures\FactoryA;
use PHPUnit\Framework\TestCase;

/**
 * Контейнер
 */
class ContainerTest extends TestCase
{
    /**
     * Возвращает конфигурацию
     */
    public function testConfig(): void
    {
        $config = new ContainerConfig();
        $container = new Container($config);
        $this->assertEquals($config, $container->config());
    }

    /**
     * Проверяет наличие
     */
    public function testHas(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
            ->defineClass(ClassA::class)
            ->getDefinition()
        );
        $this->assertTrue($container->has(ClassAInterface::class));
        $this->assertFalse($container->has('not-found'));
    }

    /**
     * Возвращает объект
     */
    public function testGetWithDefinition(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->defineClass(ClassA::class)
                ->getDefinition()
        );

        $this->assertInstanceOf(ClassAInterface::class, $container->get(ClassAInterface::class));
    }

    /**
     * Возвращает объект
     */
    public function testGetWithClass(): void
    {
        $container = new Container(new ContainerConfig());

        $this->assertInstanceOf(ClassBInterface::class, $container->get(ClassB::class));
    }

    /**
     * Возвращает объект
     */
    public function testGetNotFound(): void
    {
        $this->expectException(NotFoundException::class);

        $container = new Container(new ContainerConfig());
        $container->get(AbstractClassA::class);
    }

    /**
     * Возвращает объект
     */
    public function testGetNotFoundNotClass(): void
    {
        $this->expectException(NotFoundException::class);

        $container = new Container(new ContainerConfig());
        $container->get('not-class');
    }

    /**
     * Возвращает объект
     */
    public function testGetWithConstructor(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->defineClass(ClassA::class)
                ->getDefinition()
        );
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassCInterface::class)
                ->defineClass(ClassC::class)
                ->defineConstructor([1, true])
                ->getDefinition()
        );

        $this->assertInstanceOf(ClassCInterface::class, $container->get(ClassCInterface::class));
    }

    /**
     * Возвращает объект
     */
    public function testGetWithConstructorAssociative(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->defineClass(ClassA::class)
                ->getDefinition()
        );
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassCInterface::class)
                ->defineClass(ClassC::class)
                ->defineConstructor([
                    'parameter1' => 1,
                    'parameter2' => true,
                    'classA' => new ClassA(new ClassB()),
                ])
                ->getDefinition()
        );

        $this->assertInstanceOf(ClassCInterface::class, $container->get(ClassCInterface::class));
    }

    /**
     * Возвращает объект
     */
    public function testGetWithProperties(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->defineClass(ClassA::class)
                ->defineProperty('property1', 100)
                ->defineProperty('property2', true)
                ->getDefinition()
        );

        /**
         * @var ClassA $instance
         */
        $instance = $container->get(ClassAInterface::class);
        $this->assertInstanceOf(ClassAInterface::class, $instance);
        $this->assertEquals(100, $instance->property1);
        $this->assertEquals(true, $instance->property2);
    }

    /**
     * Возвращает объект
     */
    public function testGetWithMethods(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->defineClass(ClassA::class)
                ->defineMethod('setProperty1', [100])
                ->defineMethod('setProperty2', [true])
                ->getDefinition()
        );

        /**
         * @var ClassA $instance
         */
        $instance = $container->get(ClassAInterface::class);
        $this->assertInstanceOf(ClassAInterface::class, $instance);
        $this->assertEquals(100, $instance->property1);
        $this->assertEquals(true, $instance->property2);
    }

    /**
     * Возвращает объект созданный фабрикой
     */
    public function testGetWithFactoryClosure(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->defineFactory(function (ClassB $classB) {
                    $instance = new ClassA($classB);
                    $instance->property1 = 100;
                    $instance->property2 = true;

                    return $instance;
                })
                ->getDefinition()
        );
        /**
         * @var ClassA $instance
         */
        $instance = $container->get(ClassAInterface::class);
        $this->assertInstanceOf(ClassAInterface::class, $instance);
        $this->assertEquals(100, $instance->property1);
        $this->assertEquals(true, $instance->property2);
    }

    /**
     * Возвращает объект созданный фабрикой
     */
    public function testGetWithFactory(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->defineFactory([new FactoryA(), 'factory'])
                ->getDefinition()
        );
        /**
         * @var ClassA $instance
         */
        $instance = $container->get(ClassAInterface::class);
        $this->assertInstanceOf(ClassAInterface::class, $instance);
        $this->assertEquals(100, $instance->property1);
        $this->assertEquals(true, $instance->property2);
    }

    /**
     * Возвращает объект созданный фабрикой
     */
    public function testGetWithStaticFactory(): void
    {
        $container = new Container(new ContainerConfig());
        $container->config()->addDefinition(
            DefinitionBuilder::build(ClassAInterface::class)
                ->defineFactory([FactoryA::class, 'factoryStatic'])
                ->getDefinition()
        );
        /**
         * @var ClassA $instance
         */
        $instance = $container->get(ClassAInterface::class);
        $this->assertInstanceOf(ClassAInterface::class, $instance);
        $this->assertEquals(100, $instance->property1);
        $this->assertEquals(true, $instance->property2);
    }
}
