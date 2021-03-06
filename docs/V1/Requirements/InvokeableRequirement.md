---
currentSection: v1
currentItem: requirements
pageflow_prev_url: ComposableRequirement.html
pageflow_prev_text: ComposableRequirement class
pageflow_next_url: ListableRequirement.html
pageflow_next_text: ListableRequirement class
---

# InvokeableRequirement

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`InvokeableRequirement` is a trait. It implements the `__invoke()` and `inspect()` methods of the [`Requirement`](../Interfaces/Requirement.html) interface for you.

## Public Interface

`InvokeableRequirement` has the following public interface:

```php
// InvokeableRequirement lives in this namespace
namespace GanbaroDigital\Defensive\V1\Requirements;

trait InvokeableRequirement
{
    /**
     * throws exceptions if any of our requirements are not met
     *
     * this is an alias of to() for better readability when your
     * inspection is an object
     *
     * @inheritedFrom Inspection
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
     * @inheritedFrom Inspection
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @param  string $fieldOrVarName
     *         what is the name of $fieldOrVar in the calling code?
     * @return void
     */
    public function __invoke($fieldOrVar, $fieldOrVarName = "value");
}
```

## How To Use

### For Convenience

Use `InvokeableRequirement` in your own classes to save on typing and code duplication.

```php
use GanbaroDigital\Defensive\V1\Interfaces\Requirements;
use GanbaroDigital\Defensive\V1\Requirements\InvokeableRequirement;

class RequireInRange implements Requirement
{
    // save us having to declare __invoke() and inspect() ourselves
    use InvokeableRequirement;

    /**
     * minimum acceptable value in our range
     */
    private $min;

    /**
     * maximum acceptable value in our range
     */
    private $max;

    /**
     * constructor. used to create a customised requirement
     *
     * @param  int $min
     *         minimum value for allowed range
     * @param  int $max
     *         maximum value for allowed range
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * generates a Requirement
     *
     * @param  int $min
     *         minimum value for allowed range
     * @param  int $max
     *         maximum value for allowed range
     * @return Requirement
     *         returns a requirement to use
     */
    public static function apply($min, $max)
    {
        return new static($min, $max);
    }

    /**
     * make sure that $data is within the require range
     * throws an exception if it is not
     *
     * @param  int $data
     *         the value to check
     * @param  string $fieldOrVarName
     *         the name of $data in the caller's code
     * @return void
     */
    public function to($data, $fieldOrVarName = 'value')
    {
        if ($data < $this->min) {
            throw new RuntimeException($fieldOrVarName . ' cannot be less than ' . $this->min);
        }
        if ($data > $this->max) {
            throw new RuntimeException($fieldOrVarName . ' cannot be more than ' . $this->max);
        }
    }
}
```

## Trait Contract

Here is the contract for this trait:

    GanbaroDigital\Defensive\V1\Requirements\InvokeableRequirement
     [x] Can instantiate class that uses trait
     [x] is part of Requirement interface
     [x] calls enclosing classes to method
     [x] passes data to enclosing classes to method
     [x] passes fieldOrVarName to enclosing classes to method
     [x] inspect is alias of to method

Trait contracts are built from this trait's unit tests.

<div class="callout success">
Future releases of this trait will not break this contract.
</div>

<div class="callout info" markdown="1">
Future releases of this trait may add to this contract. New additions may include:

* clarifying existing behaviour (e.g. stricter contract around input or return types)
* add new behaviours (e.g. extra trait methods)
</div>

<div class="callout warning" markdown="1">
When you use this trait, you can only rely on the behaviours documented by this contract.

If you:

* find other ways to use this trait,
* or depend on behaviours that are not covered by a unit test,
* or depend on undocumented internal states of this trait,

... your code may not work in the future.
</div>

## Notes

None at this time.

## Changelog

### v1.2016081301

* Added `InvokeableRequirement::inspect()`

## See Also

* [`Requirement` interface](../Interfaces/Requirement.html)
