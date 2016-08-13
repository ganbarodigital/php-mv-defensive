---
currentSection: v1
currentItem: requirements
pageflow_prev_url: RequireValidAssurances.html
pageflow_prev_text: RequireValidAssurances class
---

# RequireValidRequirements

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

Use `RequireValidRequirements` to ensure that you have a list that only contains valid requirements. If this requirement is not met, an exception is thrown.

`RequireValidRequirements` is a customisable function object.

## Public Interface

`RequireValidRequirements` has the following public interface:

```php
// RequireValidRequirements lives in this namespace
namespace GanbaroDigital\Defensive\V1\Requirements;

// RequireValidRequirements is a ListRequirement
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class RequireValidRequirements implements ListRequirement
{
    /**
     * create a Requirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidRequirements
     */
    public function __construct(FactoryList $exceptions = null);

    /**
     * create a Requirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidRequirements
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

`RequireValidRequirements` enforces the following:

1. `$requirements` must be a list
1. every value in `$requirements` must implement the `Requirement` interface

If any of the requirements aren't met, `RequireValidRequirements` will throw an exception.

## How To Use

### Applying Requirements

Use the `::apply()->toList()` pattern:

```php
$requirements = [
    // a list of objects that implement the 'Requirement' interface
];
RequireValidRequirements::apply()->toList($requirements, '$requirements');
```

If any of the requirements aren't met, `RequireValidRequirements` will throw an exception.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Requirements\RequireValidRequirements
     [x] Can instantiate
     [x] is ListRequirement
     [x] Can use as object
     [x] Can call statically
     [x] Must provide list of requirements
     [x] List of requirements can contain only requirements
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

* [`Requirement` interface](../Interfaces/Requirement.html)
