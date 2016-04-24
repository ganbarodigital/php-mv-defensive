---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: index.html
pageflow_prev_text: Exceptions List
pageflow_next_url: BadRequirements.html
pageflow_next_text: BadRequirements Class
---

# BadRequirement

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`BadRequirement` is an exception. It is thrown when one of the requirements passed into `RequireAllOf` or `RequireAnyOneOf` isn't callable.

## Public Interface

`BadRequirement` has the following public interface:

```php
// our base class and interface(s)
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;

// return types from our method(s)
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;

// how to import
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;

class BadRequirement
  extends ParameterisedException
  implements DefensiveException, HttpStatusProvider
{
    // we map onto HTTP 422
    use UnprocessableEntityStatusProvider;

    /**
     * create a new exception from the requirement that has been
     * rejected
     *
     * @param  mixed $requirement
     *         the requirement that has been rejected
     * @param  array|null $callerFilter
     *         a list of classnames or partial namespaces to avoid
     *         if null, we use FilterCodeCaller::$DEFAULT_PARTIALS
     * @return BadRequirements
     */
    public static function newFromRequirement($requirement, $callerFilter = null);

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
     * @return UnprocessableEntityStatusProvider
     */
    public function getHttpStatus();
}

```

## How To Use

### Creating Exceptions To Throw

Call `BadRequirement::newFromRequirement()` to create a new throwable exception:

```php
throw BadRequirement::newFromRequirement([]);
```

### Catching The Exception

`BadRequirement` extends or implements a rich set of classes and interfaces. You can use any of these to catch thrown exceptions.

```php
// example 1: we catch only BadRequirement exceptions
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;

try {
    throw BadRequirement::newFromRequirement([]);
}
catch(BadRequirement $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Defensive Library
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;

try {
    throw BadRequirement::newFromRequirement([]);
}
catch(DefensiveException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was a problem with the
// parameter(s) passed into the method
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;
use GanbaroDigital\HttpStatus\Specifications\RequestError;

try {
    throw BadRequirement::newFromRequirement([]);
}
catch(RequestError $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;

try {
    throw BadRequirement::newFromRequirement([]);
}
catch(HttpStatusProvider $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;
use RuntimeException;

try {
    throw BadRequirement::newFromRequirement([]);
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
