---
currentSection: v1
currentItem: checks
pageflow_prev_url: index.html
pageflow_prev_text: Overview
pageflow_next_url: IsAllOf.html
pageflow_next_text: IsAllOf class
---
# ComposableCheck

<div class="callout info" markdown="1">
Since v1.2016082401
</div>

## Description

`ComposableCheck` will turn any `callable` into both a `Check` and a `ListCheck`.

## Public Interface

`ComposableCheck` has the following public interface:

```php
// ComposableCheck lives in this namespace
namespace GanbaroDigital\Defensive\V1\Checks;

// ComposableCheck is a Check
use GanbaroDigital\Defensive\V1\Interfaces\Check;
// ComposableCheck is a ListCheck
use GanbaroDigital\Defensive\V1\Interfaces\ListCheck;

// our parameter and return types
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class ComposableCheck
  implements Check, ListCheck
{
    /**
     * build a composable check
     *
     * we take a partial check (a check that needs multiple parameters),
     * plus the extra parameters, so that it can be called from our
     * IsAllOf and IsAnyOneOf classes
     *
     * @param  callable $check
     *         the partial check that we are wrapping
     * @param  array $extra
     *         the extra param(s) to pass into the underlying check
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return Check
     *         the check you can use
     */
    public function __construct(
        $check,
        $extra,
        FactoryList $exceptions = null
    );

    /**
     * does a value pass inspection?
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @return bool
     *         TRUE if the inspection passes
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

### Creating A Composable Check

Let's take a simple integer range check:

```php
// a simple test to make sure a value falls into an acceptable range
function minMaxCheck($data, $minValue, $maxValue, $fieldOrVarName) {
    if ($data < $minValue) {
        return false;
    }
    if ($data > $maxValue) {
        return false;
    }

    return true;
};
```

We can take `minMaxCheck` and use `ComposableCheck` to apply it to data:

```php
use GanbaroDigital\Defensive\V1\Checks\ComposableCheck;

// the data we will check
$data = 15;

// is $data in the range 10..20?
$check = new ComposableCheck(minMaxCheck, [10, 20]);
$check->inspect($data);
```

We can also take the `minMaxCheck` and use `ComposableCheck` to apply it to a list of data:

```php
use GanbaroDigital\Defensive\V1\Checks\ComposableCheck;

// the data we will check
$list = [15,11,13];

// are all elements in $list in the range 10..20?
$check = new ComposableCheck(minMaxCheck, [10, 20]);
$check->inspectList($list);
```

`$check` can now be used anywhere that is expecting a `Check` or  a `ListCheck` object.

The real benefit of `ComposableCheck` comes when you want to use `minMaxCheck` in a list of Checks:

```php
use GanbaroDigital\Defensive\V1\Checks\ComposableCheck;
use GanbaroDigital\Defensive\V1\Checks\IsAllOf;
use GanbaroDigital\TypeChecking\V1\Checks\IsInteger;

// putting all of the Check into a single list like this
// makes your code very easy to read and reason about
$checks = [
    new IsInteger,
    new ComposableCheck(minMaxCheck, [10, 20]),
];

// the data to check
$data = 15;

$check = new IsAllOf($checks);
$check->inspect($data);
```

You can wrap any `callable` as a `ComposableCheck` as long as:

* the first input parameter must be the data to check
* any extra parameters come next

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Checks\ComposableCheck
     [x] Can instantiate
     [x] Is check
     [x] Can use as object
     [x] Must provide a callable
     [x] Must provide array of extra parameters
     [x] Array of extra parameters can be empty
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

## Changelog

## See Also

* [`Check` interface](../Interfaces/Check.html)
* [`ListCheck` interface](../Interfaces/ListCheck.html)
