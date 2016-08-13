---
currentSection: v1
currentItem: assurances
pageflow_prev_url: EnsureAllOf.html
pageflow_prev_text: EnsureAllOf class
pageflow_next_url: InvokeableAssurance.html
pageflow_next_text: InvokeableAssurance trait
---

# EnsureAnyOneOf

<div class="callout info" markdown="1">
Since v1.2016062801
</div>

## Description

`EnsureAnyOneOf` allows you to apply a list of assurances to a piece of data. If none of the assurances are met, an exception is thrown.

`EnsureAnyOneOf` is a customisable function object.

## Public Interface

`EnsureAnyOneOf` has the following public interface:

```php
// EnsureAnyOneOf lives in this namespace
namespace GanbaroDigital\Defensive\V1\Assurances;

// EnsureAnyOneOf is an Assurance
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
// EnsureAnyOneOf is a ListAssurance
use GanbaroDigital\Defensive\V1\Interfaces\ListAssurance;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class EnsureAnyOneOf implements Assurance, ListAssurance
{
    /**
     * create an Assurance that is ready to execute
     *
     * @param array $assurances
     *        a list of the assurances to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     * @return EnsureAnyOneOf
     */
    public static function apply($assurances, FactoryList $exceptions = null);

    /**
     * throws exception if none of our assurances are met
     *
     * @param  mixed $data
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function __invoke($data, $fieldOrVarName = "value");

    /**
     * throws exception if none of our assurances are met
     *
     * @param  mixed $data
     *         the data to be examined by each assurance in turn
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
EnsureAnyOneOf::apply($assurances)->to($data, '$data');
```

Use `EnsureAnyOneOf` to catch bugs in your code:

```php
function doSomething($arg1)
{
    // do some work
    // ...

    // assurance!
    $assurances = [
        new EnsureString(),
        new EnsureNull()
    ];
    EnsureAnyOneOf::apply($assurances)->to($retval, '$retval');

    // if we get here, then we can return $retval
    return $retval;
}
```

If none of the assurances are met, `EnsureAnyOneOf` will throw an exception.

### Applying Assurances To Lists Of Data

Use the `::apply()->toList()` pattern:

```php
$assurances = [
    // a list of objects that implement the 'Assurance' interface
];
EnsureAnyOneOf::apply($assurances)->toList($list, '$list');
```

Use `EnsureAnyOneOf` to catch bugs in your code:

```php
function doSomething($arg1)
{
    // do some work
    // ...

    // assurance!
    $assurances = [
        new EnsureString(),
        new EnsureNull()
    ];
    EnsureAnyOneOf::apply($assurances)->toList($retval, '$retval');

    // if we get here, then we can return $retval
    return $retval;
}
```

If none of the assurances are met, `EnsureAnyOneOf` will throw an exception.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Assurances\EnsureAnyOneOf
     [x] Can instantiate
     [x] is Assurance
     [x] Can use as object
     [x] Can call statically
     [x] Must provide a list of assurances
     [x] Assurances list must contain valid assurances
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

## Changelog

### v1.2016081301

* now implements `ListAssurance`

## See Also

* [`Assurance` interface](../Interfaces/Assurance.html)
* [`ListAssurance` interface](../Interfaces/ListAssurance.html)
