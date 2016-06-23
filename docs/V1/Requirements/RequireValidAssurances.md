---
currentSection: v1
currentItem: assurances
pageflow_prev_url: RequireAnyOneOf.html
pageflow_prev_text: RequireAnyOneOf class
pageflow_next_url: RequireValidRequirements.html
pageflow_next_text: RequireValidRequirements class
---

# RequireValidAssurances

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

Use `RequireValidAssurances` to ensure that you have a list that only contains valid assurances. If this requirement is not met, an exception is thrown.

`RequireValidAssurances` is a customisable function object.

## Public Interface

`RequireValidAssurances` has the following public interface:

```php
// RequireValidAssurances lives in this namespace
namespace GanbaroDigital\Defensive\V1\Assurances;

// RequireValidAssurances is a Requirement
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;

// our input and return type(s)
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class RequireValidAssurances implements Requirement
{
    /**
     * create a Requirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidAssurances
     */
    public function __construct(FactoryList $exceptions = null);

    /**
     * make sure that we have a list of valid assurances to work with
     *
     * @param array $assurances
     *        the list of assurances to check
     * @param string $fieldOrVarName
     *        what is the name of $assurances in the calling code?
     * @return void
     */
    public function __invoke($assurances, $fieldOrVarName = "value");

    /**
     * create a Requirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidAssurances
     */
    public static function apply(FactoryList $exceptions = null);

    /**
     * make sure that we have a list of valid assurances to work with
     *
     * @param array $assurances
     *        the list of assurances to check
     * @param string $fieldOrVarName
     *        what is the name of $assurances in the calling code?
     * @return void
     */
    public function to($assurances, $fieldOrVarName = "value");
}
```

## Requirements Enforced

`RequireValidAssurances` enforces the following:

1. `$assurances` must be an array
2. `$assurances` cannot be empty
3. every value in `$assurances` must implement the `Assurance` interface

If any of the assurances aren't met, `RequireValidAssurances` will throw an exception.

## How To Use

### Applying Requirements

Use the `::apply()->to()` pattern:

```php
$assurances = [
    // a list of objects that implement the 'Assurance' interface
];
RequireValidAssurances::apply()->to($assurances, '$assurances');
```

If any of the requirements aren't met, `RequireValidAssurances` will throw an exception.

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Requirements\RequireValidAssurances
     [x] Can instantiate
     [x] is Requirement
     [x] Can use as object
     [x] Can call statically
     [x] Must provide list of assurances
     [x] List of assurances cannot be empty
     [x] List of assurances can contain only assurances

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

* [`Assurance` interface](Assurance.html)
