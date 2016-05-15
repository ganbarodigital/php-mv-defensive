---
currentSection: v1
currentItem: exceptions
pageflow_prev_url: BadRequirements.html
pageflow_prev_text: BadRequirements class
pageflow_next_url: UnsupportedType.html
pageflow_next_text: UnsupportedType class
---

# ContractFailed

<div class="callout warning">
Not yet in a tagged release
</div>

## Description

`ContractFailed` is an exception. It is thrown when one of the contract assertions evaluates to `false`.

## Public Interface

`ContractFailed` has the following public interface:

```php
// ContractFailed lives in this namespace
namespace GanbaroDigital\Defensive\V1\Exceptions;

// our base classes and interfaces
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Filters\FilterCodeCaller;
use GanbaroDigital\HttpStatus\Interfaces\HttpRuntimeErrorException;
use GanbaroDigital\HttpStatus\StatusProviders\RuntimeError\UnexpectedErrorStatusProvider;

// return type(s) for our methods
use GanbaroDigital\HttpStatus\StatusValues\RuntimeError\UnexpectedErrorStatus;

class ContractFailed
  extends ParameterisedException
  implements DefensiveException, HttpRuntimeErrorException
{
    // we map onto HTTP 500
    use UnexpectedErrorStatusProvider;

    /**
     * create a new exception when a value fails a contract
     *
     * @param  mixed $value
     *         the value that failed the contract
     * @param  string|null $reason
     *         details about the contract that failed
     * @return ContractFailed
     */
    public static function newFromBadValue($value, $reason = null);

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

### Creating Exceptions To Throw

Call `ContractFailed::newFromBadValue()` to create a new throwable exception:

```php
use GanbaroDigital\Defensive\V1\Exceptions\ContractFailed;

throw ContractFailed::newFromBadValue(null, '\$arg1 cannot be null');
```

### Catching The Exception

`ContractFailed` implements a rich set of classes and interfaces. You can use any of these to `catch` this exception.

```php
// example 1: we catch only ContractFailed exceptions
use GanbaroDigital\Defensive\V1\Exceptions\ContractFailed;

try {
    throw ContractFailed::newFromBadValue(null, '\$arg1 cannot be null');
}
catch(BadRequirements $e) {
    // ...
}
```

```php
// example 2: catch all exceptions thrown by the Defensive Library
use GanbaroDigital\Defensive\V1\Exceptions\ContractFailed;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;

try {
    throw ContractFailed::newFromBadValue(null, '\$arg1 cannot be null');
}
catch(DefensiveException $e) {
    // ...
}
```

```php
// example 3: catch all exceptions where there was an unexpected problem
// at runtime
use GanbaroDigital\Defensive\V1\Exceptions\ContractFailed;
use GanbaroDigital\HttpStatus\Interfaces\RuntimeError;

try {
    throw ContractFailed::newFromBadValue(null, '\$arg1 cannot be null');
}
catch(RuntimeError $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 4: catch all exceptions that map onto a HTTP status
use GanbaroDigital\Defensive\V1\Exceptions\ContractFailed;
use GanbaroDigital\HttpStatus\Interfaces\HttpException;

try {
    throw ContractFailed::newFromBadValue(null, '\$arg1 cannot be null');
}
catch(HttpException $e) {
    $httpStatus = $e->getHttpStatus();
    // ...
}
```

```php
// example 5: catch all runtime exceptions
use GanbaroDigital\Defensive\V1\Exceptions\ContractFailed;
use RuntimeException;

try {
    throw ContractFailed::newFromBadValue(null, '\$arg1 cannot be null');
}
catch(RuntimeException $e) {
    // ...
}
```

## Class Contract

Here is the contract for this class:

    GanbaroDigital\Defensive\V1\Exceptions\ContractFailed
     [x] Can instantiate
     [x] Is defensive exception
     [x] is ParameterisedException
     [x] is HttpRuntimeErrorException
     [x] maps to HTTP 500 UnexpectedError
     [x] Is runtime exception
     [x] Can create from bad value

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

??
