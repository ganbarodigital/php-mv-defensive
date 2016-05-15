---
currentSection: v1
currentItem: requirements
pageflow_prev_url: RequireAllOf.html
pageflow_prev_text: RequireAllOf class
pageflow_next_url: RequireValidRequirements.html
pageflow_next_text: RequireValidRequirements class
---

# RequireAnyOneOf

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`RequireAnyOneOf` allows you to apply a list of requirements to a piece of data. If none of the requirements are met, an exception is thrown.

`RequireAnyOneOf` is a customisable function object.

## Public Interface

`RequireAnyOneOf` has the following public interface:

```php
// RequireAnyOneOf lives in this namespace
namespace GanbaroDigital\Defensive\V1\Requirements;

// RequireAnyOneOf is a Requirement
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;

class RequireAnyOneOf implements Requirement
{
    /**
     * create a Requirement that is ready to execute
     *
     * @param array $requirements
     *        a list of the requirements to apply
     * @param array $exception
     *        the functions to call when we want to throw an exception
     * @return RequireAnyOneOf
     */
    public static function apply($requirements, $exceptions = null);

    /**
     * throws exception if none of our requirements are met
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
     * throws exception if none of our requirements are met
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
RequireAnyOneOf::apply($requirements)->to($data, '\$data');
```

Use `RequireAnyOneOf` to enforce robustness in your library's public API:

```php
function doSomething($arg1)
{
    // robustness!
    $requirements = [
        new RequireString(),
        new RequireNull()
    ];
    RequireAnyOneOf::apply($requirements)->to($arg1, '\$arg1');

    // if we get here, then $arg1 is good
}
```

If none of the requirements are met, `RequireAnyOneOf` will throw an exception.

## Notes

None at this time.

## See Also

* [`Requirement` interface](Requirement.html)
