---
currentSection: v1
currentItem: assurances
pageflow_prev_url: IsAllOf.html
pageflow_prev_text: IsAllOf class
pageflow_next_url: ListableCheck.html
pageflow_next_text: ListableCheck trait
---

# IsAnyOneOf

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`IsAnyOneOf` allows you to apply a list of checks to a piece of data. If any of the checks pass, `IsAnyOneOf` returns `true`.

`IsAnyOneOf` is a customisable function object.

## Public Interface

`IsAnyOneOf` has the following public interface:

```php
// IsAnyOneOf lives in this namespace
namespace GanbaroDigital\Defensive\V1\Checks;

// IsAnyOneOf is an Check
use GanbaroDigital\Defensive\V1\Interfaces\Check;
// IsAnyOneOf is a ListCheck
use GanbaroDigital\Defensive\V1\Interfaces\ListCheck;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class IsAnyOneOf implements Check, ListCheck
{
    /**
     * create a check that is ready to execute
     *
     * @param array $checks
     *        a list of the checks to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     * @return IsAllOf
     */
    public function __construct($checks, FactoryList $exceptions = null);

    /**
     * create a check that is ready to execute
     *
     * @param array $checks
     *        a list of the checks to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     */
    public static function using($checks, FactoryList $exceptions = null);

    /**
     * applies our list of checks to a piece of data
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined by each check in turn
     * @return bool
     *         TRUE if all checks pass
     *         FALSE otherwise
     */
    public function inspect($fieldOrVar);

    /**
     * does a list of values pass inspection?
     *
     * @param  mixed $list
     *         the list of data to be examined
     * @return bool
     *         TRUE if the inspection passes
     *         FALSE otherwise
     */
    public function inspectList($list);
}
```

## How To Use

### Applying Checks

Use the `::using()->inspect()` pattern:

```php
$checks = [
    // a list of objects that implement the 'Check' interface
];
IsAnyOneOf::using($checks)->inspect($data);
```

Use `IsAnyOneOf` to catch bugs in your code:

```php
function doSomething($arg1)
{
    // do some work
    // ...

    // assurance!
    $checks = [
        new IsString(),
        new IsNull()
    ];
    if (!IsAnyOneOf::using($checks)->inspect($retval)) {
        // the check failed
        // ...
    }

    // if we get here, then we can return $retval
    return $retval;
}
```

If none of the checks are met, `IsAnyOneOf` will return `false`.

### Applying Checks To Lists Of Data

Use the `::using()->inspectList()` pattern:

```php
$checks = [
    // a list of objects that implement the 'Check' interface
];
IsAnyOneOf::using($checks)->inspectList($list);
```

Use `IsAnyOneOf` to catch bugs in your code:

```php
function doSomething($arg1)
{
    // do some work
    // ...

    // assurance!
    $checks = [
        new IsString(),
        new IsNull()
    ];
    if (!IsAnyOneOf::using($checks)->inspectList($retval)) {
        // the checks failed
        // ...
    }

    // if we get here, then we can return $retval
    return $retval;
}
```

If none of the checks are met, `IsAnyOneOf::inspectList()` will return `false`.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Checks\IsAnyOneOf
     [x] Can instantiate
     [x] is Check
     [x] Can use as object
     [x] Can call statically
     [x] Must provide a list of assurances
     [x] Checks list must contain valid assurances
     [x] Will match any assurance given
     [x] Throws exception if nothing matches
     [x] can apply to a data list
     [x] throws InvalidArgumentException if non list passed to toList

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

## See Also

* [`Check` interface](../Interfaces/Check.html)
* [`ListCheck` interface](../Interfaces/ListCheck.html)
