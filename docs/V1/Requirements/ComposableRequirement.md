---
currentSection: v1
currentItem: requirements
pageflow_prev_url: index.html
pageflow_prev_text: Overview
pageflow_next_url: InvokeableRequirement.html
pageflow_next_text: InvokeableRequirement trait
---
# ComposableRequirement

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`ComposableRequirement` will turn any `callable` into both a `Requirement` and a `ListRequirement`.

## Public Interface

`ComposableRequirement` has the following public interface:

```php
// ComposableRequirement lives in this namespace
namespace GanbaroDigital\Defensive\V1\Requirements;

// ComposableRequirement is a Requirement
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
// ComposableRequirement is a ListRequirement
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;

// our parameter and return types
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class ComposableRequirement implements Requirement, ListRequirement
{
    /**
     * build a composable requirement
     *
     * we take a partial requirement (a requirement that needs multiple
     * parameters), plus the extra parameters, so that it can be called
     * from our RequireAllOf and RequireAnyOneOf classes
     *
     * @param  callable $requirement
     *         the partial requirement that we are wrapping
     * @param  array $extra
     *         the extra param(s) to pass into the underlying requirement
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return Requirement
     *         the requirement you can use
     */
    public function __construct($requirement, $extra, FactoryList $exceptions = null);

    /**
     * build a composable requirement
     *
     * we take a partial requirement (a requirement that needs multiple
     * parameters), plus the extra parameters, so that it can be called
     * from our RequireAllOf and RequireAnyOneOf classes
     *
     * @param  callable $requirement
     *         the partial requirement that we are wrapping
     * @param  array $extra
     *         the extra param(s) to pass into the underlying requirement
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return Requirement
     *         the requirement you can use
     */
    public static function apply($requirement, $extra, FactoryList $exceptions = null);

    /**
     * throws exception if our underlying requirement isn't met
     *
     * @param  mixed $data
     *         the data to be examined by our underlying requirement
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function to($data, $fieldOrVarName = "value");

    /**
     * throws exception if our underlying requirement isn't met
     *
     * @param  mixed $data
     *         the data to be examined by our underlying requirement
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function __invoke($data, $fieldOrVarName = "value");

    /**
     * throws exceptions if any of our requirements are not met
     *
     * this is an alias of toList() for readability
     *
     * @param  mixed $list
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function inspectList($list, $fieldOrVarName = "value");

    /**
     * throws exceptions if any of our requirements are not met
     *
     * the inspection defined in the to() method is applied to every element
     * of the list passed in
     *
     * @param  mixed $list
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function toList($list, $fieldOrVarName = "value");
}
```

## How To Use

### Creating A Composable Requirement

A `Requirement` can only take two input parameters:

* the data to check
* the name of the variable or input field being checked (to use in error messages)

That works well for simple 'is / is not' checks. But many checks are actually 'is in' checks - range checks, or making sure the input data exists in a dataset. That's where `ComposableRequirement` can be useful.

Let's take a simple integer range check:

```php
// a simple test to make sure a value falls into an acceptable range
//
// we can't use this as a Requirement, because it needs too many input params
function minMaxCheck($data, $minValue, $maxValue, $fieldOrVarName) {
    if ($data < $minValue) {
        throw new RuntimeException("$fieldOrVarName cannot be less than $minValue");
    }
    if ($data > $maxValue) {
        throw new RuntimeException("$fieldOrVarName cannot be greater than $maxValue");
    }
};
```

We can take `minMaxCheck` and use `ComposableRequirement` to apply it to data:

```php
use GanbaroDigital\Defensive\V1\Requirements\ComposableRequirement;

// the data we will check
$data = 15;

// is $data in the range 10..20?
ComposableRequirement::apply(minMaxCheck, [10, 20])->to($data, '$data');
```

The `::apply()->to()` pattern helps make your code more readable.

We can also take the `minMaxCheck` and use `ComposableRequirement` to apply it to a list of data:

```php
use GanbaroDigital\Defensive\V1\Requirements\ComposableRequirement;

// the data we will check
$list = [15,11,13];

// is $data in the range 10..20?
ComposableRequirement::apply(minMaxCheck, [10, 20])->toList($list, '$list');
```

The `::apply()->toList()` pattern helps make your code more readable.

The real benefit of `ComposableRequirement` comes when you want to use `minMaxCheck` in a list of requirements:

```php
use GanbaroDigital\Defensive\V1\Requirements\RequireAllOf;
use GanbaroDigital\Reflection\V1\Requirements\RequireInteger;

// putting all of the requirements into a single list like this
// makes your code very easy to read and reason about
$requirements = [
    new RequireInteger,
    new ComposableRequirement(minMaxCheck, [10, 20]),
];

// the data to check
$data = 15;

RequireAllOf::apply($requirements)->to($data, '$data');
```

You can wrap any `callable` as a `ComposableRequirement` as long as:

* the first input parameter must be the data to check
* any extra parameters come next
* the final parameter can be the name of the variable or field being checked

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Requirements\ComposableRequirement
     [x] Can instantiate
     [x] Is requirement
     [x] Can use as object
     [x] Can call statically
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

## See Also

* [`Requirement` interface](Requirement.html)
