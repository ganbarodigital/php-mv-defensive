---
currentSection: v1
currentItem: requirements
pageflow_prev_url: ListableRequirement.html
pageflow_prev_text: ListableRequirement trait
pageflow_next_url: RequireAnyOneOf.html
pageflow_next_text: RequireAnyOneOf class
---

# RequireAllOf

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`RequireAllOf` allows you to apply a list of requirements to a piece of data. If any of the requirements are not met, an exception is thrown.

`RequireAllOf` is a customisable function object.

## Public Interface

`RequireAllOf` has the following public interface:

```php
// RequireAllOf lives in this namespace
namespace GanbaroDigital\Defensive\V1\Requirements;

// RequireAllOf is a Requirement
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
// RequireAllOf is a ListRequirement
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class RequireAllOf implements Requirement, ListRequirement
{
    /**
     * create a Requirement that is ready to execute
     *
     * @param array $requirements
     *        a list of the requirements to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     * @return RequireAllOf
     */
    public static function apply($requirements, FactoryList $exceptions = null);

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
     * throws exceptions if any of our requirements are not met
     *
     * this is an alias of to() for better readability when your
     * inspection is an object
     *
     * @inheritedFrom ListRequirement
     *
     * @param  mixed $data
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function inspect($data, $fieldOrVarName = "value");

    /**
     * throws exception if our inspection fails
     *
     * this is an alias of to() when your inspection is an object
     * in a list
     *
     * @inheritedFrom ListRequirement
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @param  string $fieldOrVarName
     *         what is the name of $fieldOrVar in the calling code?
     * @return void
     */
    public function __invoke($fieldOrVar, $fieldOrVarName = "value");

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

## How To Use

### Applying Requirements

Use the `::apply()->to()` pattern:

```php
$requirements = [
    // a list of objects that implement the 'Requirement' interface
];
RequireAllOf::apply($requirements)->to($data, '$data');
```

Use `RequireAllOf` to enforce robustness in your library's public API:

```php
function doSomething($arg1)
{
    // robustness!
    $requirements = [
        new RequireIndexable(),
        new RequireNotEmpty()
    ];
    RequireAllOf::apply($requirements)->to($arg1, '$arg1');

    // if we get here, then $arg1 is good
}
```

If any of the requirements aren't met, the requirement will throw an exception.

### Applying Requirements To A List

Use the `::apply()->toList()` pattern:

```php
$requirements = [
    // a list of objects that implement the 'Requirement' interface
];

$list = [
    // a list of items to check
];

RequireAllOf::apply($requirements)->toList($list, '$list');
```

If any of the requirements aren't met, the requirement will throw an exception.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Requirements\RequireAllOf
     [x] Can instantiate
     [x] is Requirement
     [x] Can use as object
     [x] Can call statically
     [x] Must provide an array of requirements
     [x] Requirements array cannot be empty
     [x] Requirements array must contain valid requirements
     [x] Must match all requirements given
     [x] Throws exception if nothing matches
     [x] is ListRequirement
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

* [`Requirement` interface](Requirement.html)
