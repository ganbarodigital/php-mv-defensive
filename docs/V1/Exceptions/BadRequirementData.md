---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: index.html
pageflow_prev_text: Exceptions List
---

# BadRequirementData

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`BadRequirementData` is an exception. It is thrown when

## Public Interface

`BadRequirementData` has the following public interface:

```php
// our base class and interface(s)
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;

// return types from our method(s)
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;

// how to import
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementData;

class BadRequirementData
  extends ParameterisedException
  implements DefensiveException, HttpStatusProvider
{
    // we map onto HTTP 422
    use UnprocessableEntityStatusProvider;

    /**
     * creates a new exception about data we could not use as input parameters
     * for a single Requirement object
     *
     * @param  mixed $badData
     *         the data we could not accept
     * @param  array|null $callerFilter
     *         a list of classnames or partial namespaces to avoid
     *         if null, we use FilterCodeCaller::$DEFAULT_PARTIALS
     * @return BadRequirementData
     */
    public static function newFromRequirementData($badData, $callerFilter = null);

    /**
     * which HTTP status code do we map onto?
     * @return UnprocessableEntityStatusProvider
     */
    public function getHttpStatus();
}

```

## How To Use

### Creating Exceptions To Throw

Call `BadRequirementData::newFromRequirementData()` to create a new throwable exception:

```php
throw BadRequirementData::newFromRequirementData([]);
```

### Catching The Exception

`BadRequirementData` extends or implements a rich set of classes and interfaces. You can use any of these to catch thrown exceptions.

```php
// example 1: we catch only BadRequirementData exceptions
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementData;

try {
    throw BadRequirementData::newFromRequirementData([]);
}
catch(BadRequirementData $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Defensive Library
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementData;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;

try {
    throw BadRequirementData::newFromRequirementData([]);
}
catch(UnitTestHelpersException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was a problem with the
// parameter(s) passed into the method
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementData;
use GanbaroDigital\HttpStatus\Specifications\RequestError;

try {
    throw BadRequirementData::newFromRequirementData([]);
}
catch(RequestError $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementData;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;

try {
    throw BadRequirementData::newFromRequirementData([]);
}
catch(HttpStatusProvider $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementData;
use RuntimeException;

try {
    throw BadRequirementData::newFromRequirementData([]);
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
