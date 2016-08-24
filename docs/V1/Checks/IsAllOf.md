---
currentSection: v1
currentItem: checks
pageflow_prev_url: ComposableCheck.html
pageflow_prev_text: ComposableCheck class
pageflow_next_url: IsAnyOneOf.html
pageflow_next_text: IsAnyOneOf class
---

# IsAllOf

<div class="callout warning" markdown="1">
Not in a tagged release
</div>

## Description

`IsAllOf` allows you to apply a list of checks to a piece of data. If any of the inspections fail, `IsAllOf` returns `false`.

`IsAllOf` is a customisable function object.

## Public Interface

`IsAllOf` has the following public interface:

```php
// IsAllOf lives in this namespace
namespace GanbaroDigital\Defensive\V1\Checks;

// IsAllOf is a Check
use GanbaroDigital\Defensive\V1\Interfaces\Check;
// IsAllOf is a ListCheck
use GanbaroDigital\Defensive\V1\Interfaces\ListCheck;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class IsAllOf implements Check, ListCheck
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
IsAllOf::using($checks)->inspect($data);
```

Use `IsAllOf` to catch logic bugs in your code:

```php
function doSomething($arg1)
{
    // do some work ...

    // Check!
    $checks = [
        new IsIndexable(),
        new IsNotEmpty()
    ];
    if (!IsAllOf::using($checks)->inspect($retval)) {
        // the checks failed ...
    }

    // if we get here, then $retval is good
    return $retval;
}
```

If any of the Checks aren't met, the Check will throw an exception.

### Applying Checks To Lists Of Data

Use the `::using()->inspectList()` pattern:

```php
$checks = [
    // a list of objects that implement the 'Check' interface
];
IsAllOf::using($checks)->inspect($list);
```

`IsAllOf` will apply the list of Checks to every item in `$list`.

Use `IsAllOf` to catch logic bugs in your code:

```php
function doSomething($arg1, $arg2)
{
    // do some work ...
    $retval = [$value1, $value2];

    // Check!
    $checks = [
        new IsIndexable(),
        new IsNotEmpty()
    ];
    if (!IsAllOf::using($checks)->inspectList($retval)) {
        // the check failed
        // ...
    }

    // if we get here, then $retval is good
    return $retval;
}
```

If any of the Checks aren't met, the Check will throw an exception.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Checks\IsAllOf
     [x] Can instantiate
     [x] is Check
     [x] Can use as object
     [x] Can call statically
     [x] Must provide a list of checks
     [x] Checks list must contain valid checks
     [x] Returns false if nothing matches
     [x] can apply to a data list
     [x] throws InvalidArgumentException if non list passed to inspectList

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
