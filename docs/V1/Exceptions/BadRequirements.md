---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: BadRequirementArgs.html
pageflow_prev_text: BadRequirementArgs class
pageflow_next_url: EmptyAssurancesList.html
pageflow_next_text: EmptyAssurancesList class
---

# BadRequirements

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`BadRequirements` is an exception. It is thrown when the list of requirements passed into `RequireAllOf` or `RequireAnyOneOf` isn't an actual list.

## Public Interface

`BadRequirements` has the following public interface:

```php
// BadRequirements lives in this namespace
namespace GanbaroDigital\Defensive\V1\Exceptions;

// our base class and interface(s)
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\HttpStatus\Interfaces\HttpRequestErrorException;

// return types from our method(s)
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;

class BadRequirements
  extends ParameterisedException
  implements DefensiveException, HttpRequestErrorException
{
    // we map onto HTTP 422
    use UnprocessableEntityStatusProvider;

    /**
     * create a new exception from the requirements list that has been
     * rejected
     *
     * @param  mixed $fieldOrVar
     *         the value that you're throwing an exception about
     * @param  string $fieldOrVarName
     *         the name of the value in your code
     * @param  array $extraData
     *         extra data that you want to include in your exception
     * @param  int|null $typeFlags
     *         do we want any extra type information in the final
     *         exception message?
     * @param  array $callStackFilter
     *         are there any namespaces we want to filter out of
     *         the call stack?
     * @return BadRequirements
     *         an fully-built exception for you to throw
     */
    public static function newFromVar(
        $fieldOrVar,
        $fieldOrVarName,
        array $extraData = [],
        $typeFlags = null,
        array $callStackFilter = []
    );

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

Call `BadRequirements::newFromVar()` to create a new throwable exception:

```php
// how to import
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;

throw BadRequirements::newFromVar(null, '$list');
```

### Catching The Exception

`BadRequirements` extends or implements a rich set of classes and interfaces. You can use any of these to catch thrown exceptions.

```php
// example 1: we catch only BadRequirements exceptions
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;

try {
    throw BadRequirements::newFromVar(null, '$list');
}
catch(BadRequirements $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Defensive Library
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;

try {
    throw BadRequirements::newFromVar(null, '$list');
}
catch(DefensiveException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was a problem with the
// parameter(s) passed into the method
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;
use GanbaroDigital\HttpStatus\Interfaces\HttpRequestErrorException;

try {
    throw BadRequirements::newFromVar(null, '$list');
}
catch(HttpRequestErrorException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;
use GanbaroDigital\HttpStatus\Interfaces\HttpException;

try {
    throw BadRequirements::newFromVar(null, '$list');
}
catch(HttpException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;
use RuntimeException;

try {
    throw BadRequirements::newFromVar(null, '$list');
}
catch(RuntimeException $e) {
    // ...
}
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Exceptions\BadRequirements
     [x] Can instantiate
     [x] is DefensiveException
     [x] is RuntimeException
     [x] is HttpRequestErrorException
     [x] maps to HTTP 422 UnprocessableEntity
     [x] Can create from bad requirements list
     [x] exception states that list must contain callables

Class contracts are built from this class's unit tests.

<div class="callout success">
Future releases of this class will not break this contract.
</div>

<div class="callout info" markdown="1">
Future releases of this class may add to this contract. New additions may include:

* clarifying existing behaviour (e.g. stricter contract around input or return types)
* add new behaviours (e.g. extra class methods)
</div>

<div class="callout warning" markdown="1">
When you use this class, you can only rely on the behaviours documented by this contract.

If you:

* find other ways to use this class,
* or depend on behaviours that are not covered by a unit test,
* or depend on undocumented internal states of this class,

... your code may not work in the future.
</div>

## Notes

None at this time.

## See Also

* [`ParameterisedException` class](http://ganbarodigital.github.io/php-mv-exception-helpers/V1/BaseExceptions/ParameterisedException.html)
* [mapping exceptions onto HTTP status codes](http://ganbarodigital.github.io/php-http-status/usage/http-exceptions.html)
