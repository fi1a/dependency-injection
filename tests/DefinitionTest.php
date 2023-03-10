<?php

declare(strict_types=1);

namespace Fi1a\Unit\DI;

use Fi1a\DI\Definition;
use Fi1a\DI\Exceptions\NoValidDefinitionException;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\ClassB;
use PHPUnit\Framework\TestCase;

/**
 * Определение
 */
class DefinitionTest extends TestCase
{
    /**
     * Не валидное определение
     */
    public function testValidateEmpty(): void
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->validate();
    }

    /**
     * Не валидное определение
     */
    public function testValidateHasName(): void
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $definition->validate();
    }

    /**
     * Пустое имя
     */
    public function testNameEmpty(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->name('');
    }

    /**
     * Не валидное определение
     */
    public function testValidateHasClassNotHaveName(): void
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->className(ClassA::class);
        $definition->validate();
    }

    /**
     * Пустой класс
     */
    public function testClassNameEmpty(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->className('');
    }

    /**
     * Валидное определение
     */
    public function testValidateNameAndClass(): void
    {
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $definition->className(ClassA::class);
        $this->assertTrue($definition->validate());
    }

    /**
     * Валидное определение
     */
    public function testValidateConstructor(): void
    {
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $definition->className(ClassA::class);
        $definition->constructor([1, true]);
        $this->assertTrue($definition->validate());
    }

    /**
     * Имя
     */
    public function testName(): void
    {
        $definition = new Definition();
        $definition->name(ClassAInterface::class);
        $this->assertEquals(ClassAInterface::class, $definition->getName());
    }

    /**
     * Класс
     */
    public function testClass(): void
    {
        $definition = new Definition();
        $definition->className(ClassA::class);
        $this->assertEquals(ClassA::class, $definition->getClassName());
    }

    /**
     * Класс
     */
    public function testConstructor(): void
    {
        $definition = new Definition();
        $definition->constructor([1, true]);
        $this->assertEquals([1, true], $definition->getConstructor());
    }

    /**
     * Свойства
     */
    public function testProperties(): void
    {
        $definition = new Definition();
        $definition->property('property1', 100)
            ->property('property2', true);
        $this->assertEquals([
            'property1' => 100,
            'property2' => true,
        ], $definition->getProperties());
        $definition->properties([]);
        $this->assertEquals([], $definition->getProperties());
        $definition->properties([
            'property1' => 100,
        ]);
        $this->assertEquals([
            'property1' => 100,
        ], $definition->getProperties());
    }

    /**
     * Свойства
     */
    public function testPropertyNameException(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->property('', null);
    }

    /**
     * Свойства
     */
    public function testPropertiesNameException(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->properties(['' => null]);
    }

    /**
     * Метод, который необходимо вызвать
     */
    public function testMethod(): void
    {
        $definition = new Definition();
        $definition->method('setX', [1, 2, 3])
            ->method('setY', [true]);
        $this->assertEquals([
            'setX' => [1, 2, 3],
            'setY' => [true],
        ], $definition->getMethods());
        $definition->methods([]);
        $this->assertEquals([], $definition->getMethods());
        $definition->methods([
            'setX' => [1, 2, 3],
        ]);
        $this->assertEquals([
            'setX' => [1, 2, 3],
        ], $definition->getMethods());
    }

    /**
     * Свойства
     */
    public function testMethodNameException(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->method('', []);
    }

    /**
     * Свойства
     */
    public function testMethodsNameException(): void
    {
        $this->expectException(NoValidDefinitionException::class);

        $definition = new Definition();
        $definition->methods(['' => []]);
    }

    /**
     * Возвращает фабричный метод
     */
    public function testFactoryClosure(): void
    {
        $func = function () {
        };
        $definition = new Definition();
        $definition->factory($func);
        $this->assertEquals($func, $definition->getFactory());
    }

    /**
     * Возвращает фабричный метод
     */
    public function testFactoryCallable(): void
    {
        $definition = new Definition();
        $definition->factory([$this, 'testFactoryCallable']);
        $this->assertEquals([$this, 'testFactoryCallable'], $definition->getFactory());
    }

    /**
     * Возвращает фабричный метод
     */
    public function testFactoryException(): void
    {
        $this->expectException(NoValidDefinitionException::class);
        $definition = new Definition();
        $definition->factory($this);
    }

    /**
     * Сбрасывается название класса при установке фабричного метода
     */
    public function testSetFactoryNullClassName(): void
    {
        $definition = new Definition();
        $definition->className(ClassA::class);
        $this->assertEquals(ClassA::class, $definition->getClassName());
        $definition->factory([$this, 'testFactoryCallable']);
        $this->assertEquals([$this, 'testFactoryCallable'], $definition->getFactory());
        $this->assertNull($definition->getClassName());
    }

    /**
     * Сбрасывается фабричного метода при установке название класса
     */
    public function testSetClassNameNullFactory(): void
    {
        $definition = new Definition();
        $definition->factory([$this, 'testFactoryCallable']);
        $this->assertEquals([$this, 'testFactoryCallable'], $definition->getFactory());
        $definition->className(ClassA::class);
        $this->assertEquals(ClassA::class, $definition->getClassName());
        $this->assertNull($definition->getFactory());
    }

    /**
     * Объект
     */
    public function testObject(): void
    {
        $object = new ClassB();
        $definition = new Definition();
        $definition->object($object);
        $this->assertEquals($object, $definition->getObject());
    }

    /**
     * Сбрасывается фабричного метода при установке название класса
     */
    public function testSetClassNameNullObject(): void
    {
        $object = new ClassB();
        $definition = new Definition();
        $definition->object($object);
        $this->assertEquals($object, $definition->getObject());
        $definition->className(ClassA::class);
        $this->assertEquals(ClassA::class, $definition->getClassName());
        $this->assertNull($definition->getObject());
    }

    /**
     * Сбрасывается фабричного метода при установке название класса
     */
    public function testSetObjectNullClassName(): void
    {
        $object = new ClassB();
        $definition = new Definition();
        $definition->className(ClassA::class);
        $this->assertEquals(ClassA::class, $definition->getClassName());
        $definition->object($object);
        $this->assertEquals($object, $definition->getObject());
        $this->assertNull($definition->getClassName());
    }
}
