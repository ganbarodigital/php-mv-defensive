---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: BadRequirements.html
pageflow_prev_text: BadRequirements class
pageflow_next_url: UnsupportedType.html
pageflow_next_text: UnsupportedType class
---

# BadRequirementArgs

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`BadRequirementArgs` is an exception. It is thrown when data passed into `RequireAllOf` or `RequireAnyOneOf` isn't an array.

## Public Interface

`BadRequirementArgs` has the following public interface:

```php
// BadRequirementArgs lives in this namespace
namespace GanbaroDigital\Defensive\V1\Exceptions;

// our base class and interface(s)
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;

// return types from our method(s)
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;

class BadRequirementArgs
  extends ParameterisedException
  implements DefensiveException, HttpStatusProvider
{
    // we map onto HTTP 422
    use UnprocessableEntityStatusProvider;

    /**
     * creates a new exception about data we could not use as input parameters
     * for a single Requirement object
     *
     * @param  mixed $badArgs
     *         the data we could not accept
     * @param  array|null $callerFilter
     *         a list of classnames or partial namespaces to avoid
     *         if null, we use FilterCodeCaller::$DEFAULT_PARTIALS
     * @return BadRequirementArgs
     */
    public static function newFromRequirementArgs($badArgs, $callerFilter = null);

    /**
     * what was the data that we used to create the printable message?
     *
     * @return array
     */
    public function getMessageData();

    /**
     * what was the format string we used to create the printable message?
     *
     * @return string
     */
    public function getMessageFormat();

    /**
     * which HTTP status code do we map onto?
     *
     * @return UnprocessableEntityStatus
     */
    public function getHttpStatus();
}

```

## How To Use

### Creating Exceptions To Throw

Call `BadRequirementArgs::newFromRequirementArgs()` to create a new throwable exception:

```php
// how to import
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementArgs;

throw BadRequirementArgs::newFromRequirementArgs([]);
```

### Catching The Exception

`BadRequirementArgs` extends or implements a rich set of classes and interfaces. You can use any of these to catch thrown exceptions.

```php
// example 1: we catch only BadRequirementArgs exceptions
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementArgs;

try {
    throw BadRequirementArgs::newFromRequirementArgs([]);
}
catch(BadRequirementArgs $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Defensive Library
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementArgs;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;

try {
    throw BadRequirementArgs::newFromRequirementArgs([]);
}
catch(DefensiveException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was a problem with the
// parameter(s) passed into the method
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementArgs;
use GanbaroDigital\HttpStatus\Specifications\RequestError;

try {
    throw BadRequirementArgs::newFromRequirementArgs([]);
}
catch(RequestError $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementArgs;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;

try {
    throw BadRequirementArgs::newFromRequirementArgs([]);
}
catch(HttpStatusProvider $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementArgs;
use RuntimeException;

try {
    throw BadRequirementArgs::newFromRequirementArgs([]);
}
catch(RuntimeException $e) {
    // ...
}
```

## Notes

None at this time.

## See Also

* [`ParameterisedException` class](http://ganbarodigital.github.io/php-mv-exception-helpers/V1/BaseExceptions/ParameterisedException.html)
* [`HttpStatusProvider` interface](http://ganbarodigital.github.io/php-http-status/httpStatusProviders.html)
