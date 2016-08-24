---
currentSection: v1
currentItem: requirements
pageflow_prev_url: RequireAnyOneOf.html
pageflow_prev_text: RequireAnyOneOf class
pageflow_next_url: RequireValidRequirements.html
pageflow_next_text: RequireValidRequirements class
---

# RequireValidChecks

<div class="callout info" markdown="1">
Since v1.2016082401
</div>

## Description

Use `RequireValidChecks` to ensure that you have a list that only contains valid checks. If this requirement is not met, an exception is thrown.

`RequireValidChecks` is a customisable function object.

## Public Interface

`RequireValidChecks` has the following public interface:

```php
// RequireValidChecks lives in this namespace
namespace GanbaroDigital\Defensive\V1\Checks;

// RequireValidChecks is a ListRequirement
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class RequireValidChecks implements ListRequirement
{
    /**
     * create a ListRequirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidChecks
     */
    public function __construct(FactoryList $exceptions = null);

    /**
     * create a Requirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidChecks
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

`RequireValidChecks` enforces the following:

1. `$fieldOrVar` must be a list
1. every value in `$fieldOrVar` must implement the `Check` interface

If any of the requirements aren't met, `RequireValidChecks` will throw an exception.

## How To Use

### Applying Requirements

Use the `::apply()->toList()` pattern:

```php
$assurances = [
    // a list of objects that implement the 'Check' interface
];
RequireValidChecks::apply()->toList($checks, '$checks');
```

If any of the requirements aren't met, `RequireValidChecks` will throw an exception.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Requirements\RequireValidChecks
     [x] Can instantiate
     [x] is ListRequirement
     [x] Can use as object
     [x] Can call statically
     [x] Must provide list of checks
     [x] List of checks can contain only checks
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

* [`ListCheck` interface](../Interfaces/ListCheck.html)
