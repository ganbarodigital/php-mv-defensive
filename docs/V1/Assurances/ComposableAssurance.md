---
currentSection: v1
currentItem: assurances
pageflow_prev_url: index.html
pageflow_prev_text: Overview
pageflow_next_url: EnsureAllOf.html
pageflow_next_text: EnsureAllOf class
---
# ComposableAssurance

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`ComposableAssurance` will turn any `callable` into a `Assurance`.

## Public Interface

`ComposableAssurance` has the following public interface:

```php
// ComposableAssurance lives in this namespace
namespace GanbaroDigital\Defensive\V1\Assurances;

// ComposableAssurance is a Assurance
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;

// our parameter and return types
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class ComposableAssurance implements Assurance
{
    /**
     * build a composable assurance
     *
     * we take a partial assurance (a assurance that needs multiple
     * parameters), plus the extra parameters, so that it can be called
     * from our EnsureAllOf and EnsureAnyOneOf classes
     *
     * @param  callable $assurance
     *         the partial assurance that we are wrapping
     * @param  array $extra
     *         the extra param(s) to pass into the underlying assurance
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return Assurance
     *         the assurance you can use
     */
    public function __construct($assurance, $extra, FactoryList $exceptions = null);

    /**
     * build a composable assurance
     *
     * we take a partial assurance (a assurance that needs multiple
     * parameters), plus the extra parameters, so that it can be called
     * from our EnsureAllOf and EnsureAnyOneOf classes
     *
     * @param  callable $assurance
     *         the partial assurance that we are wrapping
     * @param  array $extra
     *         the extra param(s) to pass into the underlying assurance
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return Assurance
     *         the assurance you can use
     */
    public static function apply($assurance, $extra, FactoryList $exceptions = null);

    /**
     * throws exception if our underlying assurance isn't met
     *
     * @param  mixed $data
     *         the data to be examined by our underlying assurance
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function to($data, $fieldOrVarName = "value");

    /**
     * throws exception if our underlying assurance isn't met
     *
     * @param  mixed $data
     *         the data to be examined by our underlying assurance
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function __invoke($data, $fieldOrVarName = "value");
}
```

## How To Use

### Creating A Composable Assurance

An `Assurance` can only take two input parameters:

* the data to check
* the name of the variable or input field being checked (to use in error messages)

That works well for simple 'is / is not' checks. But many checks are actually 'is in' checks - range checks, or making sure the input data exists in a dataset. That's where `ComposableAssurance` can be useful.

Let's take a simple integer range check:

```php
// a simple test to make sure a value falls into an acceptable range
//
// we can't use this as an Assurance, because it needs too many input params
function minMaxCheck($data, $minValue, $maxValue, $fieldOrVarName) {
    if ($data < $minValue) {
        throw new RuntimeException("$fieldOrVarName cannot be less than $minValue");
    }
    if ($data > $maxValue) {
        throw new RuntimeException("$fieldOrVarName cannot be greater than $maxValue");
    }
};
```

We can take `minMaxCheck` and use `ComposableAssurance` to apply it to data:

```php
use GanbaroDigital\Defensive\V1\Assurances\ComposableAssurance;

// the data we will check
$data = 15;

// is $data in the range 10..20?
ComposableAssurance::apply(minMaxCheck, [10, 20])->to($data, '$data');
```

The `::apply()->to()` pattern helps make your code more readable.

The real benefit of `ComposableAssurance` comes when you want to use `minMaxCheck` in a list of assurances:

```php
use GanbaroDigital\Defensive\V1\Assurances\EnsureAllOf;
use GanbaroDigital\TypeChecking\V1\Assurances\EnsureInteger;

// putting all of the assurance into a single list like this
// makes your code very easy to read and reason about
$assurances = [
    new EnsureInteger,
    new ComposableAssurance(minMaxCheck, [10, 20]),
];

// the data to check
$data = 15;

EnsureAllOf::apply($assurances)->to($data, '$data');
```

You can wrap any `callable` as a `ComposableAssurance` as long as:

* the first input parameter must be the data to check
* any extra parameters come next
* the final parameter can be the name of the variable or field being checked

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Assurances\ComposableAssurance
     [x] Can instantiate
     [x] Is assurance
     [x] Can use as object
     [x] Can call statically
     [x] Must provide a callable
     [x] Must provide array of extra parameters
     [x] Array of extra parameters can be empty

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

* [`Assurance` interface](../Interfaces/Assurance.html)
