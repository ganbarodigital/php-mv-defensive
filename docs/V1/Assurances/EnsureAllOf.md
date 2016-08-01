---
currentSection: v1
currentItem: assurances
pageflow_prev_url: ComposableAssurance.html
pageflow_prev_text: ComposableAssurance class
pageflow_next_url: EnsureAnyOneOf.html
pageflow_next_text: EnsureAnyOneOf class
---

# EnsureAllOf

<div class="callout info" markdown="1">
Since v1.2016062801
</div>

## Description

`EnsureAllOf` allows you to apply a list of assurances to a piece of data. If any of the inspections fail, an exception is thrown.

`EnsureAllOf` is a customisable function object.

## Public Interface

`EnsureAllOf` has the following public interface:

```php
// EnsureAllOf lives in this namespace
namespace GanbaroDigital\Defensive\V1\Assurances;

// EnsureAllOf is an Assurance
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
// EnsureAllOf is a ListAssurance
use GanbaroDigital\Defensive\V1\Interfaces\ListAssurance;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class EnsureAllOf implements Assurance, ListAssurance
{
    /**
     * create an Assurance that is ready to execute
     *
     * @param array $assurances
     *        a list of the assurances to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     * @return EnsureAllOf
     */
    public static function apply($assurances, FactoryList $exceptions = null);

    /**
     * throws exceptions if any of our assurances are not met
     *
     * @param  mixed $data
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function __invoke($data, $fieldOrVarName = "value");

    /**
     * throws exceptions if any of our assurances are not met
     *
     * @param  mixed $data
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function to($data, $fieldOrVarName = "value");

    /**
     * throws exceptions if any of our assurances are not met
     *
     * this is an alias of toList() for readability
     *
     * @param  mixed $list
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function inspectList($list, $fieldOrVarName = "value");

    /**
     * throws exceptions if any of our assurances are not met
     *
     * the inspection defined in the to() method is applied to every element
     * of the list passed in
     *
     * @param  mixed $list
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function toList($list, $fieldOrVarName = "value");
}
```

## How To Use

### Applying Assurances

Use the `::apply()->to()` pattern:

```php
$assurances = [
    // a list of objects that implement the 'Assurance' interface
];
EnsureAllOf::apply($assurances)->to($data, '$data');
```

Use `EnsureAllOf` to catch logic bugs in your code:

```php
function doSomething($arg1)
{
    // do some work ...

    // assurance!
    $assurances = [
        new EnsureIndexable(),
        new EnsureNotEmpty()
    ];
    EnsureAllOf::apply($assurances)->to($retval, '$retval');

    // if we get here, then $retval is good
    return $retval;
}
```

If any of the assurances aren't met, the assurance will throw an exception.

### Applying Assurances To Lists Of Data

Use the `::apply()->toList()` pattern:

```php
$assurances = [
    // a list of objects that implement the 'Assurance' interface
];
EnsureAllOf::apply($assurances)->toList($list, '$list');
```

`EnsureAllOf` will apply the list of assurances to every item in `$list`.

Use `EnsureAllOf` to catch logic bugs in your code:

```php
function doSomething($arg1, $arg2)
{
    // do some work ...
    $retval = [$value1, $value2];

    // assurance!
    $assurances = [
        new EnsureIndexable(),
        new EnsureNotEmpty()
    ];
    EnsureAllOf::apply($assurances)->toList($retval, '$retval');

    // if we get here, then $retval is good
    return $retval;
}
```

If any of the assurances aren't met, the assurance will throw an exception.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Assurances\EnsureAllOf
     [x] Can instantiate
     [x] is Assurance
     [x] Can use as object
     [x] Can call statically
     [x] Must provide an array of assurances
     [x] Assurances array cannot be empty
     [x] Assurances array must contain valid assurances
     [x] Must match all assurances given
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

## Changelog

### v1.2016080101

* now implements `ListAssurance`

## See Also

* [`Assurance` interface](../Interfaces/Assurance.html)
