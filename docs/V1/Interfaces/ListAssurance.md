---
currentSection: v1
currentItem: interfaces
pageflow_prev_url: Inspection.html
pageflow_prev_text: Inspection interface
pageflow_next_url: ListInspection.html
pageflow_next_text: ListInspection interface
---

# ListAssurance

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`ListAssurance` is an interface. It's the interface for [`ListInspection`](ListInspection.html)s performed against:

* lists of returned values
* lists of calculated / generated values

If you want to inspect a list of input values, use a [`ListRequirement`](ListRequirement.html).

## Public Interface

`ListAssurance` has the following public interface:

```php
// ListAssurance lives in this namespace
namespace GanbaroDigital\Defensive\V1\Interfaces;

// our base interface
use GanbaroDigital\Defensive\V1\Interfaces\ListInspection;

interface ListAssurance
  extends ListInspection
{
    /**
     * throws exception if our inspection fails
     *
     * @inheritedFrom ListInspection
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
     * @inheritedFrom ListInspection
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
     * @inheritedFrom ListInspection
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
     * @inheritedFrom ListInspection
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

### The Apply->ToList Pattern

Every `ListAssurance` implements the `ListAssurance::apply()->toList()` pattern:

* add `implements ListAssurance` to your existing `Assurance` class.
* add `use ListableAssurance` to your class. Saves you having to implement `toList()` and `inspectList()` yourself.
* add a `public static function apply()` method to your class, and a corresponding `__construct()` method. `apply()` takes any extra parameters needed to customise the assurance, and returns a new instance of your class.
* add a `public function to()` method to your class. This method inspects `$data`. If you're not happy with `$data`, throw an exception.

For example, here's a simple min / max assurance:

```php
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
use GanbaroDigital\Defensive\V1\Interfaces\ListAssurance;
use GanbaroDigital\Defensive\V1\Assurance\InvokeableAssurance;
use GanbaroDigital\Defensive\V1\Assurance\ListableAssurance;

class EnsureInRange implements Assurance, ListAssurance
{
    // save us having to declare __invoke() ourselves
    use InvokeableAssurance;

    // saves us having to declare toList() ourselves
    use ListableAssurance;

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
            throw new RuntimeException(
                $fieldOrVarName . ' cannot be less than ' . $this->min
            );
        }
        if ($data > $this->max) {
            throw new RuntimeException(
                $fieldOrVarName . ' cannot be more than ' . $this->max
            );
        }
    }
}
```

To use this example assurance, you would do:

```php
$list = [
    25,
    20
];

// every entry in $list must be >=10, and <=20
EnsureInRange::apply(10, 20)->toList($list, '$list');
```
