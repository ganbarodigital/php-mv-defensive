---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: BadRequirementData.html
pageflow_prev_text: BadRequirementData class
---

# UnsupportedType

<div class="callout warning" markdown="1">
Not yet in a tagged release
</div>

## Description

`UnsupportedType` is an exception. It is thrown when a variable of the wrong data type is passed into a method.

## Public Interface

`UnsupportedType` has the following public interface:

```php
// our namespace
namespace GanbaroDigital\Defensive\V1\Exceptions;

// our base class and interface(s)
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\UnsupportedType as BaseUnsupportedType;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;

// return types from our method(s)
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;

class UnsupportedType
  extends BaseUnsupportedType
  implements DefensiveException, HttpStatusProvider
{
    // we map onto HTTP 422
    use UnprocessableEntityStatusProvider;

    /**
     * create a new exception
     *
     * @param  mixed $var
     *         the variable that has the unsupported type
     * @param  string $fieldOrVarName
     *         the name of the input field, PHP variable or function/method
     *         parameter that contains $data
     * @param  int|null $typeFlags
     *         do we want any extra type information in the final exception message?
     * @param  array|null $callerFilter
     *         are there any namespaces we want to filter out of the call stack?
     * @return UnsupportedType
     *         an fully-built exception for you to throw
     */
    public static function newFromVar($var, $fieldOrVarName, $typeFlags = null, $callerFilter = null);

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

Call `UnsupportedType::newFromVar()` to create a new throwable exception:

```php
// how to import
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;

throw UnsupportedType::newFromVar($data, '\$data');
```

### Catching The Exception

`UnsupportedType` extends or implements a rich set of classes and interfaces. You can use any of these to catch thrown exceptions.

```php
// example 1: we catch only UnsupportedType exceptions
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;

try {
    throw UnsupportedType::newFromVar($data, '\$data');
}
catch(UnsupportedType $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Defensive Library
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;

try {
    throw UnsupportedType::newFromVar($data, '\$data');
}
catch(DefensiveException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was a problem with the
// parameter(s) passed into the method
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\HttpStatus\Specifications\RequestError;

try {
    throw UnsupportedType::newFromVar($data, '\$data');
}
catch(RequestError $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;

try {
    throw UnsupportedType::newFromVar($data, '\$data');
}
catch(HttpStatusProvider $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use RuntimeException;

try {
    throw UnsupportedType::newFromVar($data, '\$data');
}
catch(RuntimeException $e) {
    // ...
}
```

## Notes

None at this time.

## See Also

* [`UnsupportedType` class](http://ganbarodigital.github.io/php-mv-exception-helpers/V1/BaseExceptions/UnsupportedType.html)
* [`HttpStatusProvider` interface](http://ganbarodigital.github.io/php-http-status/httpStatusProviders.html)
