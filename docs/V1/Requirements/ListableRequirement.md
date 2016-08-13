---
currentSection: v1
currentItem: requirements
pageflow_prev_url: InvokeableRequirement.html
pageflow_prev_text: InvokeableRequirement trait
pageflow_next_url: RequireAllOf.html
pageflow_next_text: RequireAllOf class
---

# ListableRequirement

<div class="callout info" markdown="1">
Since v1.2016081301
</div>

## Description

`ListableRequirement` is a trait. It implements the `toList()` and `inspectList()` methods of the [`ListRequirement`](../Interfaces/ListRequirement.html) interface for you.

## Public Interface

`ListableRequirement` has the following public interface:

```php
// ListableRequirement lives in this namespace
namespace GanbaroDigital\Defensive\V1\Requirements;

trait ListableRequirement
{
    /**
     * throws exceptions if any of our Requirements are not met
     *
     * this is an alias of toList() for readability
     *
     * @param  mixed $list
     *         the data to be examined by each Requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function inspectList($list, $fieldOrVarName = "value");

    /**
     * throws exceptions if any of our Requirements are not met
     *
     * the inspection defined in the to() method is applied to every element
     * of the list passed in
     *
     * @param  mixed $list
     *         the data to be examined by each Requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function toList($list, $fieldOrVarName = "value");
}
```

## How To Use

### For Convenience

Use `ListableRequirement` in your own classes to save on typing and code duplication.

```php
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;
use GanbaroDigital\Defensive\V1\Requirements\InvokeableRequirement;
use GanbaroDigital\Defensive\V1\Requirements\ListableRequirement;

class EnsureInRange implements Requirement, ListRequirement
{
    // save us having to declare __invoke() ourselves
    use InvokeableRequirement;

    // save us having to declare toList() ourselves
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
     * constructor. used to create a customised Requirement
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
     * generates an Requirement
     *
     * @param  int $min
     *         minimum value for allowed range
     * @param  int $max
     *         maximum value for allowed range
     * @return Requirement
     *         returns an Requirement to use
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

To use this example Requirement, you would do:

```php
$list = [
    25,
    20
];

// every entry in $list must be >=10, and <=20
EnsureInRange::apply(10, 20)->toList($list, '$list');
```

## Trait Contract

Here is the contract for this trait:

    GanbaroDigital\Defensive\V1\Requirements\ListableRequirement
     [x] Can instantiate class that uses trait
     [x] is part of ListRequirement interface
     [x] can inspect an array of data via toList
     [x] can inspect an array of data via inspectList
     [x] can inspect a Traversable object via toList
     [x] can inspect a Traversable object via inspectList
     [x] can inspect a stdClass object via toList
     [x] can inspect a stdClass object via inspectList
     [x] throws InvalidArgumentException when non list passed to toList
     [x] throws InvalidArgumentException when non list passed to inspectList

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

* [`Requirement` interface](../Interfaces/Requirement.html)
