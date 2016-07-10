---
currentSection: v1
currentItem: interfaces
pageflow_prev_url: Inspection.html
pageflow_prev_text: Inspection interface
pageflow_next_url: Requirement.html
pageflow_next_text: Requirement interface
---

# ListInspection

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`ListInspection` is an interface. It defines the `::apply()->toList()` pattern.

## Public Interface

`ListInspection` has the following public interface:

```php
// ListInspection lives in this namespace
namespace GanbaroDigital\Defensive\V1\Interfaces;

interface ListInspection extends Inspection
{
    /**
     * throws exception if our inspection fails
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

Use the `::apply()->toList()` pattern to make sure that every entry in a list meets your requirement:

```php
function foo(array $args)
{
    // robustness!
    // every entry in $args must be a string
    RequireStringy::apply()->toList($args, '$args');

    // this is shorthand for:
    $requirement = RequireStringy::apply();
    foreach ($args as $key => $item) {
        $requirement->to($item, '$args[' . $key . ']');
    }
}
```

Here's how the pattern works:

* `::apply()` is a static factory method. It returns a new inspection object.
* If `::apply()` has any parameters, these are used to customise the behaviour of the inspection object.
* `::toList()` is a method on the inspection object. It calls `::to()` for each element in the list that you pass in.

<div class="callout info" markdown="1">
#### What Is A List?

`::toList()` accepts any of these as a list:

* an array
* an object that implements `Traversable`
* a `stdClass` object
</div>

## Notes

None at this time.
