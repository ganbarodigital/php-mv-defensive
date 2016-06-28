---
currentSection: v1
currentItem: requirements
pageflow_prev_url: EnsureAnyOneOf.html
pageflow_prev_text: EnsureAnyOneOf class
---

# InvokeableAssurance

<div class="callout info" markdown="1">
Since v1.2016062801
</div>

## Description

`InvokeableAssurance` is a trait. It implements the `__invoke()` method of the [`Assurance`](../Interfaces/Assurance.html) interface for you.

## Public Interface

`InvokeableAssurance` has the following public interface:

```php
// InvokeableAssurance lives in this namespace
namespace GanbaroDigital\Defensive\V1\Assurances;

trait InvokeableAssurance
{
    /**
     * throws exceptions if any of our assurances are not met
     *
     * @param  mixed $data
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function __invoke($data, $fieldOrVarName = "value");
}
```

## How To Use

### For Convenience

Use `InvokeableAssurance` in your own classes to save on typing and code duplication.

```php
use GanbaroDigital\Defensive\V1\Interfaces\Assurances;
use GanbaroDigital\Defensive\V1\Assurances\InvokeableAssurance;

class EnsureInRange implements Assurance
{
    // save us having to declare __invoke() ourselves
    use InvokeableAssurance;

    /**
     * minimum acceptable value in our range
     */
    private $min;

    /**
     * maximum acceptable value in our range
     */
    private $max;

    /**
     * constructor. used to create a customised assurance
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
     * generates an Assurance
     *
     * @param  int $min
     *         minimum value for allowed range
     * @param  int $max
     *         maximum value for allowed range
     * @return Assurance
     *         returns a requirement to use
     */
    public static function apply($min, $max)
    {
        return new static($min, $max);
    }

    /**
     * make sure that $data is within the specified range
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

    GanbaroDigital\Defensive\V1\Assurances\InvokeableAssurance
     [x] Can instantiate class that uses trait
     [x] is part of Assurance interface
     [x] calls enclosing classes to method
     [x] passes data to enclosing classes to method
     [x] passes fieldOrVarName to enclosing classes to method

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

## See Also

* [`Assurance` interface](../Interfaces/Assurance.html)
