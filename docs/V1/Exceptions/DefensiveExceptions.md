---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: UnsupportedValue.html
pageflow_prev_text: UnsupportedValue class
---

# DefensiveExceptions

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`DefensiveExceptions` is a [`FactoryList`](http://ganbarodigital.github.io/php-mv-di-containers/V1/Interfaces/FactoryList.html). It provides factory methods for all exceptions that the _Defensive Library_ can throw.

## Public Interface

`DefensiveExceptions` has the following public interface.

```php
// DefensiveExceptions lives in this namespace
namespace GanbaroDigital\Defensive\V1\Exceptions;

// our base classes and interfaces
use GanbaroDigital\DIContainers\V1\FactoryList\Containers\FactoryListContainer;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class DefensiveExceptions extends FactoryListContainer
{
    public function __construct();

    /**
     * return the full list of factories as a real PHP array
     *
     * @return array
     * @inheritedFrom FactoryList
     */
    public function getList();
}
```

## How To Use

### Construction

Here's how to build a new instance of `DefensiveExceptions`.

```php
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions;

$diContainer = new DefensiveExceptions;
```

### Creating A New Exception

Treat `DefensiveExceptions` as a PHP array that contains factory methods. Each factory's name is the same _class::method_ that you would use to call the exception's factory directly.

```php
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions;

$diContainer = new DefensiveExceptions;

throw $diContainer['BadRequirement::newFromVar'](false, '$data');
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions
     [x] Can instantiate
     [x] Is factory list
     [x] has factory for BadAssurance newFromInputParameter
     [x] has factory for BadAssurance newFromVar
     [x] has factory for BadAssuranceArgs newFromInputParameter
     [x] has factory for BadAssuranceArgs newFromVar
     [x] has factory for BadAssurancesList newFromInputParameter
     [x] has factory for BadAssurancesList newFromVar
     [x] has factory for EmptyAssurancesList newFromInputParameter
     [x] has factory for EmptyAssurancesList newFromVar
     [x] has factory for BadCallable newFromInputParameter
     [x] has factory for BadCallable newFromVar
     [x] has factory for BadCheckArgs newFromInputParameter
     [x] has factory for BadCheckArgs newFromVar
     [x] has factory for BadRequirement newFromInputParameter
     [x] has factory for BadRequirement newFromVar
     [x] has factory for BadRequirementArgs newFromInputParameter
     [x] has factory for BadRequirementArgs newFromVar
     [x] has factory for BadRequirements newFromInputParameter
     [x] has factory for BadRequirements newFromVar
     [x] has factory for EmptyRequirementsList newFromInputParameter
     [x] has factory for EmptyRequirementsList newFromVar
     [x] has factory for UnreachableCodeExecuted newAlert
     [x] has factory for UnsupportedType newFromInputParameter
     [x] has factory for UnsupportedType newFromVar
     [x] has factory for UnsupportedValue newFromInputParameter
     [x] has factory for UnsupportedValue newFromVar

Class contracts are built from this class's unit tests.

<div class="callout success">
Future releases of this class will not break this contract.
</div>

<div class="callout info" markdown="1">
Future releases of this class may add to this contract. New additions may include:

* clarifying existing behaviour (e.g. stricter contract around input or return types)
* add new behaviours (e.g. extra class methods)
</div>

<div class="callout warning" markdown="1">
When you use this class, you can only rely on the behaviours documented by this contract.

If you:

* find other ways to use this class,
* or depend on behaviours that are not covered by a unit test,
* or depend on undocumented internal states of this class,

... your code may not work in the future.
</div>

## Notes

None at this time.
