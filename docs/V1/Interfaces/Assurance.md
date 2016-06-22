---
currentSection: v1
currentItem: interfaces
pageflow_prev_url: index.html
pageflow_prev_text: Interfaces
pageflow_next_url: Inspection.html
pageflow_next_text: Inspection interface
---

# Assurance

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`Assurance` is an interface. It's the interface for [`Inspection`](Inspection.html)s performed against:

* returned values
* calculated / generated values

If you want to inspect an input value, use a [`Requirement`](Requirement.html).

<div class="callout info" markdown="1">
#### What's The Difference Between An Assurance And A Requirement?

Requirements and assurances are both inspections. They perform the same checks, just at different places in your code.

* At the start of your method, use requirements to inspect your method's input parameters.
* Later on in your method, use assurances to inspect the return values of any methods you call.
* At the end of your method, use assurances to inspect the value your method is going to return.

Internally, the only difference between a `Requirement` and an `Assurance` is how they create the exceptions that they throw.

* A `Requirement` will use an exception's `::newFromInputParameter()` static factory method.
* An `Assurance` will use an exception's `::newFromVar()` static factory method.

This means that the exception (and, ultimately your app's log files) will have different error messages and supporting data depending on whether a `Requirement` wasn't met, or an `Assurance` wasn't met.
</div>

## Public Interface

`Assurance` has the following public interface:

```php
// Assurance lives in this namespace
namespace GanbaroDigital\Defensive\V1\Interfaces;

// our base interface
use GanbaroDigital\Defensive\V1\Interfaces\Inspection;

interface Assurance
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
    public function __invoke($fieldOrVar, $fieldOrVarName = "value");

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
}
```

## How To Use

### The Apply->To Pattern

Every `Assurance` implements the `Assurance::apply()->to()` pattern:

* add `implements Assurance` to your class
* add `use InvokeableAssurance` to your class. Saves you having to implement `__invoke()` yourself.
* add a `public static function apply()` method to your class, and a corresponding `__construct()` method. `apply()` takes any extra parameters needed to customise the assurance, and returns a new instance of your class.
* add a `public function to()` method to your class. This method inspects `$data`. If you're not happy with `$data`, throw an exception.

For example, here's a simple min / max assurance:

```php
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
use GanbaroDigital\Defensive\V1\Assurance\InvokeableAssurance;

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
     *         returns an assurance to use
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

To use this example assurance, you would do:

```php
// $data must be >=10, and <=20
EnsureInRange::apply(10, 20)->to($data, '$data');
```

## Notes

1. We have `__invoke()` in the interface to make it easy to work with lists of assurances.
