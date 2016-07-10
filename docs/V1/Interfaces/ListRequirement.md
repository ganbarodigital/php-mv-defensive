---
currentSection: v1
currentItem: interfaces
pageflow_prev_url: ListInspection.html
pageflow_prev_text: ListInspection interface
pageflow_next_url: Requirement.html
pageflow_next_text: Requirement interface
---

# ListRequirement

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`ListRequirement` is an interface. It's the interface for [`ListInspection`](ListInspection.html)s performed against input values that are lists.

If you want to inspect lists of returned values or lists of generated / calculated values, use a [`ListAssurance`](ListAssurance.html).

## Public Interface

`ListRequirement` has the following public interface:

```php
// ListRequirement lives in this namespace
namespace GanbaroDigital\Defensive\V1\Interfaces;

// our base interface
use GanbaroDigital\Defensive\V1\Interfaces\ListInspection;

interface ListRequirement
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

Every `ListRequirement` implements the `ListRequirement::apply()->toList()` pattern:

* add `implements ListRequirement` to your existing `Requirement` class.
* add `use ListableRequirement` to your class. Saves you having to implement `toList()` and `inspectList()` yourself.
* add a `public static function apply()` method to your class, and a corresponding `__construct()` method. `apply()` takes any extra parameters needed to customise the requirement, and returns a new instance of your class.
* add a `public function to()` method to your class. This method inspects `$data`. If you're not happy with `$data`, throw an exception.

For example, here's a simple min / max assurance:

```php
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\Defensive\V1\Requirements\InvokeableRequirement;
use GanbaroDigital\Defensive\V1\Requirements\ListableRequirement;

class RequireInRange implements Requirement, ListRequirement
{
    // save us having to declare __invoke() ourselves
    use InvokeableRequirement;

    // saves us having to declare toList() ourselves
    use ListableRequirement;

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

To use this example requirement, you would do:

```php
$list = [
    25,
    20
];

// every entry in $list must be >=10, and <=20
RequireInRange::apply(10, 20)->toList($list, '$list');
```
