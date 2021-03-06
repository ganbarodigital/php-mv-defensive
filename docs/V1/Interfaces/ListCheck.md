---
currentSection: v1
currentItem: interfaces
pageflow_prev_url: ListAssurance.html
pageflow_prev_text: ListAssurance interface
pageflow_next_url: ListInspection.html
pageflow_next_text: ListInspection interface
---

# ListCheck

<div class="callout info" markdown="1">
Since v1.2016082401
</div>

## Description

`ListCheck` is an interface. It's the interface for `true` / `false` inspections of a list of data.

<div class="callout info" markdown="1">
#### What's The Difference Between A Check, And Assurances / Requirements?

Checks are _questions_, Assurances and Requirements are _quality inspections_.

Checks are `IsXXX()`-type calls. Their job is to look at your data, and say if your data "is" something or not. For example, `IsStringy()` will tell you if your data can be used as a string or not. It isn't necessarily an error if a check returns `false`. That's why checks never throw exceptions.

Assurances and Requirements are looking at your data to make sure everything is okay. For example, `RequireStringy()` makes sure that your data can be used as a string. A failed Assurance or Requirement is treated as an error, complete with exceptions thrown and dreams dashed.

It's good practice for your Assurances and Requirements to be built on top of your Checks wherever possible.
</div>

## Public Interface

`ListCheck` has the following public interface:

```php
// ListCheck lives in this namespace
namespace GanbaroDigital\Defensive\V1\Interfaces;

interface ListCheck
{
    /**
     * does a value pass inspection?
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @return bool
     *         TRUE if the inspection passes
     *         FALSE otherwise
     */
    public function inspect($fieldOrVar);

    /**
     * does a list of values pass inspection?
     *
     * @param  mixed $list
     *         the data to be examined
     * @return bool
     *         TRUE if the inspection passes
     *         FALSE otherwise
     */
    public function inspectList($list);
}
```

`ListCheck` also has the following informal interface:

```php
interface ListCheck
{
    /**
     * does a value pass inspection?
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @return bool
     *         TRUE if the inspection passes
     *         FALSE otherwise
     */
    public static function check($fieldOrVar, <additional params>);

    /**
     * does a list of values pass inspection?
     *
     * @param  mixed $list
     *         the data to be examined
     * @return bool
     *         TRUE if the inspection passes
     *         FALSE otherwise
     */
    public static function checkList($list, <additional params>);
}
```

_Informal interfaces_ contain methods that you must implement. However, due to PHP limitations, we can't add these methods to the `interface` at this time.

## How To Use

Every `ListCheck` can be used in two ways:

* a static call to `::checkList()` for convenience,
* as an object, calling the `->inspectList()` method

### Scaffolding

Most `ListCheck` classes also implement the `Check` interface too. See [the `Check` interface](Check.html) to get started.

Every `ListCheck` needs a bit of boilerplate code:

* add `use GanbaroDigital\Defensive\V1\Interfaces\ListCheck` to your PHP file
* add `implements ListCheck` to your class

### The Check Pattern

Every `ListCheck` implements the `ListCheck::checkList()` pattern:

* add a `public static function checkList()` method to your class. This method inspects each element in `$list`. If you're happy with `$list`, return `true`. If you're not happy with `$list`, return `false`.
* if your check needs additional input parameters, pass these in as additional parameters to the `checkList()` method.

### Making It Usable As An Object

Every `ListCheck` can be used as an object:

* add a `public function __construct()` if your check needs additional input parameters
* add a `public function inspectList()` which calls your `::inspect()` method

We've provided a [`ListableCheck` trait](../Checks/ListableTrait.html) that will add `inspectList()` to your class.

### Putting It All Together

Here's a simple min / max check. It supports all the different ways that a `ListCheck` can be used.

```php
use GanbaroDigital\Defensive\V1\Checks\ListableCheck;
use GanbaroDigital\Defensive\V1\Interfaces\Check;
use GanbaroDigital\Defensive\V1\Interfaces\ListCheck;

class IsInRange implements Check, ListCheck
{
    // saves us having to implement inspectList() ourselves
    use ListableCheck;

    /**
     * minimum acceptable value in our range
     */
    private $min;

    /**
     * maximum acceptable value in our range
     */
    private $max;

    /**
     * constructor. used to create a customised check
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
     * is $data within the require range?
     *
     * @param  int $data
     *         the value to check
     * @return bool
     *         TRUE if the data is in range
     *         FALSE otherwise
     */
    public function inspect($data)
    {
        return static::check($data, $this->min, $this->max);
    }

    /**
     * is $data within the required range?
     *
     * @param  int $data
     *         the value to check
     * @param  int $min
     *         minimum value for allowed range
     * @param  int $max
     *         maximum value for allowed range
     * @return bool
     *         TRUE if the data is in range
     *         FALSE otherwise
     */
    public static function check($data, $min, $max)
    {
        if ($data < $this->min) {
            return false;
        }
        if ($data > $this->max) {
            return false;
        }

        return true;
    }

    /**
     * are the values in $list within the required range?
     *
     * @param  mixed $list
     *         the list of values to check
     * @param  int $min
     *         minimum value for allowed range
     * @param  int $max
     *         maximum value for allowed range
     * @return bool
     *         TRUE if the data is in range
     *         FALSE otherwise
     */
    public static function checkList($list, $min, $max)
    {
        $check = new static($min, $max);
        return $check->inspectList($list);
    }
}
```

To use this example check, you can do:

```php
// a static call is often the most convenient
var_dump(IsInRange::checkList($list, 10,20));

// as an object
$callable = new IsInRange(10, 20);
var_dump($rangeCheck->inspect($data));
var_dump($rangeCheck->inspectList($list));
```
