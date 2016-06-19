---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: EmptyRequirementsList.html
pageflow_prev_text: EmptyRequirementsList class
pageflow_next_url: UnsupportedType.html
pageflow_next_text: UnsupportedType class
---

# UnreachableCodeExecuted

<div class="callout info" markdown="1">
Since v1.2016052101
</div>

## Description

`UnreachableCodeExecuted` is an exception. Throw this exception whenever your `switch` statements or `if` / `else` statements have branches that should never be executed.

## Public Interface

`UnreachableCodeExecuted` has the following public interface:

```php
// UnreachableCodeExecuted lives in this namespace
namespace GanbaroDigital\Defensive\V1\Exceptions;

// our base classes and interfaces
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Filters\FilterCodeCaller;
use GanbaroDigital\HttpStatus\Interfaces\HttpRuntimeErrorException;
use GanbaroDigital\HttpStatus\StatusProviders\RuntimeError\UnexpectedErrorStatusProvider;

// our return type(s)
use GanbaroDigital\HttpStatus\StatusValues\RuntimeError\UnexpectedErrorStatus;

class UnreachableCodeExecuted
  extends ParameterisedException
  implements DefensiveException, HttpRuntimeErrorException
{
    // we map onto HTTP 500
    use UnexpectedErrorStatusProvider;

    /**
     * creates a new exception about unreachable code that has, in fact,
     * been executed
     *
     * @return UnreachableCodeExecuted
     */
    public static function newAlert();

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
     * @return UnexpectedErrorStatus
     */
    public function getHttpStatus();
}
```

## How To Use

### Alerting About Unreachable Code

Use `UnreachableCodeExecuted` to detect when a `switch` statement is missing one or more `case` clauses:

```php
use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;

switch($state) {
    case DirectDebit::STATE_CREATED:
        // ...
        break;
    case DirectDebit::STATE_SUBMITTED:
        // ...
        break;
    default:
        // if we get here, our direct debit is in a state that we have
        // no support for
        throw UnreachableCodeExecuted::newAlert();
}
```

or when an `if` / `else` statement reaches a branch that should never happen:

```php
use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;

if ($state === DirectDebit::STATE_CREATED) {
    // ...
}
else if ($state === DirectDebit::STATE_SUBMITTED) {
    // ...
}
else {
    // if we get here, our direct debit is in an unsupported state
    throw UnreachableCodeExecuted::newAlert();
}
```

You should use `UnreachableCodeExecuted` as a placeholder. When you have the time, go back and define an explicit exception for each error where you've used `UnreachableCodeExecuted`. This will make your code even easier to support.

### Catching The Exception

`UnreachableCodeExecuted` implements a rich set of classes and interfaces. You can use any of these to `catch` this exception.

```php
// example 1: we catch only UnreachableCodeExecuted exceptions
use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;

try {
    throw UnreachableCodeExecuted::newAlert();
}
catch(BadRequirements $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Defensive Library
use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;

try {
    throw UnreachableCodeExecuted::newAlert();
}
catch(DefensiveException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was an unexpected problem
// at runtime
use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;
use GanbaroDigital\HttpStatus\Interfaces\HttpRuntimeErrorException;

try {
    throw UnreachableCodeExecuted::newAlert();
}
catch(HttpRuntimeErrorException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;
use GanbaroDigital\HttpStatus\Interfaces\HttpException;

try {
    throw UnreachableCodeExecuted::newAlert();
}
catch(HttpException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;
use RuntimeException;

try {
    throw UnreachableCodeExecuted::newAlert();
}
catch(RuntimeException $e) {
    // ...
}
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\Exceptions\UnreachableCodeExecuted
     [x] Can instantiate
     [x] Is defensive exception
     [x] is ParameterisedException
     [x] is HttpRuntimeErrorException
     [x] maps to HTTP 500 UnexpectedError
     [x] Is runtime exception
     [x] Can raise new alert
     [x] New alert message includes caller details
     [x] New alert data includes caller details

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
