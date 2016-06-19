---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: BadRequirement.html
pageflow_prev_text: BadRequirement class
pageflow_next_url: UnreachableCodeExecuted.html
pageflow_next_text: UnreachableCodeExecuted class
---

# EmptyRequirementsList

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`EmptyRequirementsList` is an exception. It is thrown when the list of requirements passed into `RequireAllOf` or `RequireAnyOneOf` is an empty list.

## Public Interface

`EmptyRequirementsList` has the following public interface:

```php
// EmptyRequirementsList lives in this namespace
namespace GanbaroDigital\Defensive\V1\Exceptions;

// our base class and interface(s)
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\HttpStatus\Interfaces\HttpRequestErrorException;

// return types from our method(s)
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;

class EmptyRequirementsList
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
     * @return EmptyRequirementsList
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

Call `EmptyRequirementsList::newFromVar()` to create a new throwable exception:

```php
// how to import
use GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList;

throw EmptyRequirementsList::newFromVar(null, '$list');
```

### Catching The Exception

`EmptyRequirementsList` extends or implements a rich set of classes and interfaces. You can use any of these to catch thrown exceptions.

```php
// example 1: we catch only EmptyRequirementsList exceptions
use GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList;

try {
    throw EmptyRequirementsList::newFromVar([], '$list');
}
catch(EmptyRequirementsList $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Defensive Library
use GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;

try {
    throw EmptyRequirementsList::newFromVar([], '$list');
}
catch(DefensiveException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was a problem with the
// parameter(s) passed into the method
use GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList;
use GanbaroDigital\HttpStatus\Interfaces\HttpRequestErrorException;

try {
    throw EmptyRequirementsList::newFromVar([], '$list');
}
catch(HttpRequestErrorException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList;
use GanbaroDigital\HttpStatus\Interfaces\HttpException;

try {
    throw EmptyRequirementsList::newFromVar([], '$list');
}
catch(HttpException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList;
use RuntimeException;

try {
    throw EmptyRequirementsList::newFromVar([], '$list');
}
catch(RuntimeException $e) {
    // ...
}
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList
     [x] Can instantiate
     [x] is DefensiveException
     [x] is RuntimeException
     [x] is HttpRequestErrorException
     [x] maps to HTTP 422 UnprocessableEntity
     [x] Can create from empty requirements list list
     [x] exception states that list must not be empty

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
