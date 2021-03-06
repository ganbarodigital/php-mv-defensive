---
currentSection: v1
currentItem: interfaces
pageflow_prev_url: ListRequirement.html
pageflow_prev_text: ListRequirement interface
---

# Requirement

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`Requirement` is an interface. It is the base interface that all requirements extend.

## Public Interface

`Requirement` has the following public interface:

```php
// Requirement lives in this namespace
namespace GanbaroDigital\Defensive\V1\Interfaces;

// our base interface
use GanbaroDigital\Defensive\V1\Interfaces\Inspection;

interface Requirement
  extends Inspection
{
    /**
     * throws exception if our inspection fails
     *
     * @inheritedFrom Inspection
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

### The Apply->To Pattern

Every `Requirement` implements the `Requirement::apply()->to()` pattern:

* add `implements Requirement` to your class
* add `use InvokeableRequirement` to your class. Saves you having to implement `__invoke()` yourself.
* add a `public static function apply()` method to your class, and a corresponding `__construct()` method. `apply()` takes any extra parameters needed to customise the requirement, and returns a new instance of your class.
* add a `public function to()` method to your class. This method inspects `$data`. If you're not happy with `$data`, throw an exception.

For example, here's a simple min / max requirement:

```php
use GanbaroDigital\Defensive\V1\Interfaces\Requirements;
use GanbaroDigital\Defensive\V1\Requirements\InvokeableRequirement;

class RequireInRange implements Requirement
{
    // save us having to declare __invoke() ourselves
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

To use this example requirement, you would do:

```php
// $data must be >=10, and <=20
RequireInRange::apply(10, 20)->to($data);
```

## Notes

1. We have `__invoke()` in the interface to make it easy to work with lists of requirements.

## Changelog

### v1.2016062801

* `Requirement` now extends the `Inspection` interface
