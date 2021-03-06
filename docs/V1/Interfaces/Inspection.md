---
currentSection: v1
currentItem: interfaces
pageflow_prev_url: Check.html
pageflow_prev_text: Check interface
pageflow_next_url: ListAssurance.html
pageflow_next_text: ListAssurance interface
---

# Inspection

<div class="callout info" markdown="1">
Since v1.2016062801
</div>

## Description

`Inspection` is an interface. It defines the `::apply()->to()` pattern used by both [`Assurance`](../Assurances/index.html) and [`Requirement`](../Requirements/index.html) classes.

## Public Interface

`Inspection` has the following public interface:

```php
// Inspection lives in this namespace
namespace GanbaroDigital\Defensive\V1\Interfaces;

interface Inspection
{
    /**
     * throws exception if our inspection fails
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @param  string $fieldOrVarName
     *         what is the name of $fieldOrVar in the calling code?
     * @return void
     */
    public function __invoke($fieldOrVar, $fieldOrVarName = "value");

    /**
     * throws exception if our inspection fails
     *
     * this is an alias of to() for readability purposes
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @param  string $fieldOrVarName
     *         what is the name of $fieldOrVar in the calling code?
     * @return void
     */
    public function inspect($fieldOrVar, $fieldOrVarName = "value");

    /**
     * throws exception if our inspection fails
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @param  string $fieldOrVarName
     *         what is the name of $fieldOrVar in the calling code?
     * @return void
     */
    public function to($fieldOrVar, $fieldOrVarName = "value");
}
```

## How To Use

### A Base Interface

`Inspection` is a base interface. Its purpose is to define common functionality.

* Create new interfaces that extend `Inspection` to provide type-hinting for different kinds of inspections.
* New Inspections should not add additional functionality.
* Do not add additional public methods to your Inspections.

[`Assurance`](Assurance.html) and [`Requirement`](Requirement.html) are both interfaces that extend `Inspection`.

### The Apply->To Pattern

All inspections follow the `::apply()->to()` pattern:

```php
function foo($args)
{
    // robustness!
    RequireListOfFish::apply()->to($args, '$args');

    // ... do some work

    // all done
    EnsureInRange::apply(100, 200)->to($retval, '$retval');
    return $retval;
}
```

Here's how the pattern works:

* `::apply()` is a static factory method. It returns a new inspection object.
* If `::apply()` has any parameters, these are used to customise the behaviour of the inspection object.
* `::to()` is a method on the inspection object. It performs the inspection, and throws an exception if the data passed into it doesn't pass the inspection.
* Each inspection object also has an `::__invoke()` method, so that you can create lists of inspections to run through.

The benefits of this pattern include:

* composability: the objects returned by `::apply()` are all composable. You can put them in a list, and then use them against the same data (see [`RequireAnyOneOf`](../Requirements/RequireAnyOneOf.html) for an example).
* relatively stateless: the pattern encourages creating new inspection objects, rather than attempting to reuse the same inspection objects over and over. With Storyplayer, we learned and proved that this approach keeps defects to a minimum.

The downside of the pattern is that each inspection takes a minimum of three method calls:

1. Your code calls `::apply()`
2. Internally, `::apply()` creates a new object and calls its `::__construct()`
3. Your code calls `::to()` on the created object

<div class="callout success" markdown="1">
It's our experience - and our thesis - that the time it takes a developer to write and ship working code is now the biggest bottleneck on projects. Some of this cost is writing the code the first time, and some of this cost is going back and debugging the code and fixing errors only discovered by your customers.

Adding strict error detection to code (in the form of inspections) helps you ship code that works first time. Reducing post-release maintenance and support frees up more time to spend on writing new code.
</div>

In PHP 7.0 onwards, method calls aren't the major overhead that they used to be, which helps a lot. Plus, you can take advantage of the new behaviour of `assert()` in PHP 7.0 to switch off all inspections in your code if you need to:

```php
// only works in PHP 7.0 and up
//
// set assert.active=0 in php.ini to disable all assert() calls
assert(EnsureInRange::apply(100,200)->to($retval));
```

### Inspection Adapters

You can use all implementations of `Inspection` as _inspection adapters_:

```php
$assurances = [
    new EnsureString(),
    new EnsureMinLength(100)
];
foreach ($assurances as $assurance) {
    // invokeable object
    $assurance($data, '$data');

    // for readability, this works too
    $assurance->inspect($data, '$data');
}
```

Here's how this pattern works:

* `Inspection::__invoke()` and `Inspection::inspect()` both call `Inspection::to()` underneath
* if your class uses either the [`InvokeableAssurance`](../Assurances/InvokeableAssurance.html) or [`InvokeableRequirement`](../Requirements/InvokeableRequirement.html) trait, you get this behaviour for free

## Notes

None at this time.

## Changelog

### v1.2016081301

* Added `Inspection::inspect()` method

  This is implemented by both the [`InvokeableAssurance`](../Assurances/InvokeableAssurance.html) and [`InvokeableRequirement`](../Requirements/InvokeableRequirement.html) traits. Your code should be using these to provide the convenience methods specified in the `Inspection` interface.
