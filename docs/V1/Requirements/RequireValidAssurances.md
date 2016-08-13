---
currentSection: v1
currentItem: requirements
pageflow_prev_url: RequireAnyOneOf.html
pageflow_prev_text: RequireAnyOneOf class
pageflow_next_url: RequireValidRequirements.html
pageflow_next_text: RequireValidRequirements class
---

# RequireValidAssurances

<div class="callout info" markdown="1">
Since v1.2016081301
</div>

## Description

Use `RequireValidAssurances` to ensure that you have a list that only contains valid assurances. If this requirement is not met, an exception is thrown.

`RequireValidAssurances` is a customisable function object.

## Public Interface

`RequireValidAssurances` has the following public interface:

```php
// RequireValidAssurances lives in this namespace
namespace GanbaroDigital\Defensive\V1\Assurances;

// RequireValidAssurances is a ListRequirement
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class RequireValidAssurances implements ListRequirement
{
    /**
     * create a ListRequirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidAssurances
     */
    public function __construct(FactoryList $exceptions = null);

    /**
     * create a Requirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidAssurances
     */
    public static function apply(FactoryList $exceptions = null);

    /**
     * throws exception if our inspection fails
     *
     * @inheritedFrom ListRequirement
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @param  string $fieldOrVarName
     *         what is the name of $fieldOrVar in the calling code?
     * @return void
     */
    public function to($fieldOrVar, $fieldOrVarName = "value");

    /**
     * throws exception if our inspection fails
     *
     * the inspection defined in the to() method is applied to every element
     * of the list passed in
     *
     * @inheritedFrom ListRequirement
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     *         must be a traversable list
     * @param  string $fieldOrVarName
     *         what is the name of $fieldOrVar in the calling code?
     * @return void
     */
    public function toList($fieldOrVar, $fieldOrVarName = "value");

    /**
     * throws exception if our inspection fails
     *
     * this is an alias of toList() for better readability when your
     * inspection is an object
     *
     * @inheritedFrom ListRequirement
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     *         must be a traversable list
     * @param  string $fieldOrVarName
     *         what is the name of $fieldOrVar in the calling code?
     * @return void
     */
    public function inspectList($fieldOrVar, $fieldOrVarName = "value");
}
```

## Requirements Enforced

`RequireValidAssurances` enforces the following:

1. `$assurances` must be a list
1. every value in `$assurances` must implement the `Assurance` interface

If any of the assurances aren't met, `RequireValidAssurances` will throw an exception.

## How To Use

### Applying Requirements

Use the `::apply()->toList()` pattern:

```php
$assurances = [
    // a list of objects that implement the 'Assurance' interface
];
RequireValidAssurances::apply()->toList($assurances, '$assurances');
```

If any of the requirements aren't met, `RequireValidAssurances` will throw an exception.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Requirements\RequireValidAssurances
     [x] Can instantiate
     [x] is ListRequirement
     [x] Can use as object
     [x] Can call statically
     [x] Must provide list of assurances
     [x] List of assurances can contain only assurances
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

* Implements `ListRequirement` instead of `Requirement`

  We feel this is a more accurate description of what this function class does.

## See Also

* [`Assurance` interface](Assurance.html)
