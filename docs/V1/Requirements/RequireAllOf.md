---
currentSection: v1
currentItem: requirements
pageflow_prev_url: InvokeableRequirement.html
pageflow_prev_text: InvokeableRequirement trait
pageflow_next_url: RequireAnyOneOf.html
pageflow_next_text: RequireAnyOneOf class
---

# RequireAllOf

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`RequireAllOf` allows you to apply a list of requirements to a piece of data. If any of the requirements are not met, an exception is thrown.

`RequireAllOf` is a customisable function object.

## Public Interface

`RequireAllOf` has the following public interface:

```php
// RequireAllOf lives in this namespace
namespace GanbaroDigital\Defensive\V1\Requirements;

// RequireAllOf is a Requirement
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;

class RequireAllOf implements Requirement
{
    /**
     * create a Requirement that is ready to execute
     *
     * @param array $requirements
     *        a list of the requirements to apply
     * @param array $exception
     *        the functions to call when we want to throw an exception
     * @return RequireAllOf
     */
    public static function apply($requirements, $exceptions = null);

    /**
     * throws exceptions if any of our requirements are not met
     *
     * @param  mixed $data
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @param  array|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return void
     */
    public function __invoke($data, $fieldOrVarName = "value", $exceptions = null);

    /**
     * throws exceptions if any of our requirements are not met
     *
     * @param  mixed $data
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @param  array|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return void
     */
    public function to($data, $fieldOrVarName = "value", $exceptions = null);
}
```

## How To Use

### Applying Requirements

Use the `::apply()->to()` pattern:

```php
$requirements = [
    // a list of objects that implement the 'Requirement' interface
];
RequireAllOf::apply($requirements)->to($data, '\$data');
```

Use `RequireAllOf` to enforce robustness in your library's public API:

```php
function doSomething($arg1)
{
    // robustness!
    $requirements = [
        new RequireIndexable(),
        new RequireNotEmpty()
    ];
    RequireAllOf::apply($requirements)->to($arg1, '\$arg1');

    // if we get here, then $arg1 is good
}
```

If any of the requirements aren't met, the requirement will throw an exception.

## Notes

None at this time.

## See Also

* [`Requirement` interface](Requirement.html)
