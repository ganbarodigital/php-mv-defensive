---
currentSection: v1
currentItem: assurances
pageflow_prev_url: InvokeableAssurance.html
pageflow_prev_text: InvokeableAssurance trait
---

# ListableAssurance

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`ListableAssurance` is a trait. It implements the `toList()` and `inspectList()` methods of the [`ListAssurance`](../Interfaces/ListAssurance.html) interface for you.

## Public Interface

`ListableAssurance` has the following public interface:

```php
// ListableAssurance lives in this namespace
namespace GanbaroDigital\Defensive\V1\Assurances;

trait ListableAssurance
{
    /**
     * throws exceptions if any of our assurances are not met
     *
     * this is an alias of toList() for readability
     *
     * @param  mixed $list
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function inspectList($list, $fieldOrVarName = "value");

    /**
     * throws exceptions if any of our assurances are not met
     *
     * the inspection defined in the to() method is applied to every element
     * of the list passed in
     *
     * @param  mixed $list
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function toList($list, $fieldOrVarName = "value");
}
```

## How To Use

### For Convenience

Use `ListableAssurance` in your own classes to save on typing and code duplication.

```php
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
use GanbaroDigital\Defensive\V1\Interfaces\ListAssurance;
use GanbaroDigital\Defensive\V1\Assurances\InvokeableAssurance;
use GanbaroDigital\Defensive\V1\Assurances\ListableAssurance;

class EnsureInRange implements Assurance, ListAssurance
{
    // save us having to declare __invoke() ourselves
    use InvokeableAssurance;

    // save us having to declare toList() ourselves
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

To use this example assurance, you would do:

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

    GanbaroDigital\Defensive\V1\Assurances\ListableAssurance
     [x] Can instantiate class that uses trait
     [x] is part of ListAssurance interface
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

* [`Assurance` interface](../Interfaces/Assurance.html)
