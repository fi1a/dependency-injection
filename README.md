# Dependency injection container

[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
![Coverage Status][badge-coverage]
[![Total Downloads][badge-downloads]][downloads]

Контейнер [dependency injection](http://en.wikipedia.org/wiki/Dependency_injection),
может разрешать зависимости, создавать экземпляры и настраивать классы. 
Поддерживает внедрение конструктора, свойств и методов.

## Установка

Установить этот пакет можно как зависимость, используя Composer.

``` bash
composer require fi1a/dependency-injection
```

## Использование контейнера

Для использования контейнера dependency injection, сначала необходимо в конфигурацию задать определения созданное с помощью builder'а.
Название определения обычно является именем интерфейса. Когда запрашивается тип для создания объекта, будет использоваться это определение.
Это происходит при вызове метода `get` непосредственно из контейнера. Объекты также создаются не явно при разрешении зависимостей.

```php
use Fi1a\DI\Container;
use Fi1a\DI\ContainerConfig;
use Fi1a\DI\Builder;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\ClassC;
use Fi1a\Unit\DI\Fixtures\ClassCInterface;

$config = new ContainerConfig();

$config->addDefinition(
    Builder::build(ClassAInterface::class)
        ->defineClass(ClassA::class)
        ->getDefinition()
);

$config->addDefinition(
    Builder::build(ClassCInterface::class)
        ->defineClass(ClassC::class)
        ->defineConstructor([1, true])
        ->getDefinition()
);

$container = new Container($config);

$container->get(ClassCInterface::class); // ClassCInterface
```

Объект может быть определен несколькими способами:

- defineClass - сопоставление с конкретным классом;
- defineFactory - если реализация сложная и может быть лучше описана в коде, то следует использовать фабричный метод. При использовании фабричного метода, зависимости в аргументах автоматически разрешаются.
- defineObject - вернуть созданный экземпляр объекта.

Также доступны следующие определения:

- defineConstructor - задает аргументы для конструктора класса определенного как defineClass;
- defineProperty - задает значение свойства объекта;
- defineProperties - задает ассоциативный массив со значениями свойств объекта;
- defineMethod - задает метод объекта, который необходимо вызвать с объявленными аргументами;
- defineMethods - задает ассоциативный массив с методами объекта, которые необходимо вызвать с объявленными аргументами.

При отсутствии определения для запрашиваемого типа, контейнер выбросит исключение `Fi1a\DI\Exceptions\NotFoundException`.

## defineClass

Сопоставление с конкретным классом, определение аргументов конструктора, задание свойств и вызов методов:

```php
use Fi1a\DI\Container;
use Fi1a\DI\ContainerConfig;
use Fi1a\DI\Builder;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;

$config = new ContainerConfig();

$config->addDefinition(
    Builder::build(ClassAInterface::class)
        ->defineClass(ClassA::class)
        ->defineConstructor([
            'parameter1' => 10,
        ])
        ->defineProperty('property1', 100)
        ->defineMethod('setProperty2', [true])
        ->getDefinition()
);

$container = new Container($config);

/** @var ClassA $object */
$object = $container->get(ClassAInterface::class); // ClassAInterface

$object->property1; // 100
$object->property2; // true
```

## defineFactory

Используется замыкание как фабричный метод:

```php
use Fi1a\DI\Container;
use Fi1a\DI\ContainerConfig;
use Fi1a\DI\Builder;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\ClassB;

$config = new ContainerConfig();

$config->addDefinition(
    Builder::build(ClassAInterface::class)
        ->defineFactory(function (ClassB $classB) {
            $instance = new ClassA($classB);
            $instance->property1 = 100;
            $instance->property2 = true;

            return $instance;
        })
        ->getDefinition()
);

$container = new Container($config);

/** @var ClassA $object */
$object = $container->get(ClassAInterface::class); // ClassAInterface

$object->property1; // 100
$object->property2; // true
```

Использование фабричного метода в классе:

```php
use Fi1a\DI\Container;
use Fi1a\DI\ContainerConfig;
use Fi1a\DI\Builder;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\FactoryA;

$config = new ContainerConfig();

$config->addDefinition(
    Builder::build(ClassAInterface::class)
        ->defineFactory([FactoryA::class, 'factoryStatic'])
        ->getDefinition()
);

$container = new Container($config);

/** @var ClassA $object */
$object = $container->get(ClassAInterface::class); // ClassAInterface

$object->property1; // 100
$object->property2; // true
```

## defineObject

Использовать уже созданный экземпляр объекта:

```php
use Fi1a\DI\Container;
use Fi1a\DI\ContainerConfig;
use Fi1a\DI\Builder;
use Fi1a\Unit\DI\Fixtures\ClassB;
use Fi1a\Unit\DI\Fixtures\ClassBInterface;

$config = new ContainerConfig();

$config->addDefinition(
    Builder::build(ClassBInterface::class)
        ->defineObject(new ClassB())
        ->getDefinition()
);

$container = new Container($config);

/** @var ClassB $object */
$object = $container->get(ClassBInterface::class); // ClassBInterface
```

## Хелпер di

Доступен хелпер `di()`, возвращающий один экземпляр контейнера для регистрации опредлений в других пакетах.

```php
use Fi1a\DI\Builder;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;
use Fi1a\Unit\DI\Fixtures\ClassC;
use Fi1a\Unit\DI\Fixtures\ClassCInterface;

di()->config()->addDefinition(
    Builder::build(ClassAInterface::class)
        ->defineClass(ClassA::class)
        ->getDefinition()
);

di()->config()->addDefinition(
    Builder::build(ClassCInterface::class)
        ->defineClass(ClassC::class)
        ->defineConstructor([1, true])
        ->getDefinition()
);

di()->get(ClassCInterface::class); // ClassCInterface
```

## Создание определения из массива

Для создания определения из массива можно воспользоваться методом `buildFromArray` класса реализующего интерфейс `Fi1a\DI\ArrayBuilderInterface`:

```php
use Fi1a\DI\ArrayBuilder;
use Fi1a\DI\Container;
use Fi1a\DI\ContainerConfig;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;

$config = new ContainerConfig();

$config->addDefinition(
    $definition = ArrayBuilder::buildFromArray([
        'name' => ClassAInterface::class,
        'class_name' => ClassA::class,
        'constructor' => [100, true],
        'properties' => [
            'property1' => 100,
            'property2' => true,
        ],
        'methods' => [
            'setProperty1' => [100],
            'setProperty2' => [true],
        ],
    ])->getDefinition()
);

$container = new Container($config);

/** @var ClassA $object */
$object = $container->get(ClassAInterface::class); // ClassAInterface
```

## Преобразование определения и коллекций в массив

Для преобразования определений и коллекций в массив, можно воспользоваться методом `definition`, или `collection` класса реализующего интерфейс `Fi1a\DI\ToArrayInterface`:

```php
use Fi1a\DI\ContainerConfig;
use Fi1a\DI\Builder;
use Fi1a\DI\ToArray;
use Fi1a\Unit\DI\Fixtures\ClassA;
use Fi1a\Unit\DI\Fixtures\ClassAInterface;

$config = new ContainerConfig();

$definition = Builder::build(ClassAInterface::class)
    ->defineClass(ClassA::class)
    ->defineConstructor([
        'parameter1' => 10,
    ])
    ->defineProperty('property1', 100)
    ->defineMethod('setProperty2', [true])
    ->getDefinition();

$config->addDefinition($definition);

$toArray = new ToArray();

$array = $toArray->collection($config->getDefinitions()); // [[...], [...]]
$arrayDefinition = $toArray->definition($definition); // [...]
```

[badge-release]: https://img.shields.io/packagist/v/fi1a/dependency-injection?label=release
[badge-license]: https://img.shields.io/github/license/fi1a/dependency-injection?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/fi1a/dependency-injection?style=flat-square
[badge-coverage]: https://img.shields.io/badge/coverage-100%25-green
[badge-downloads]: https://img.shields.io/packagist/dt/fi1a/dependency-injection.svg?style=flat-square&colorB=mediumvioletred

[packagist]: https://packagist.org/packages/fi1a/dependency-injection
[license]: https://github.com/fi1a/dependency-injection/blob/master/LICENSE
[php]: https://php.net
[downloads]: https://packagist.org/packages/fi1a/dependency-injection