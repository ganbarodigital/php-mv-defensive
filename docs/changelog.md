---
currentSection: overview
currentItem: changelog
pageflow_prev_url: multivariant.html
pageflow_prev_text: Multi-Variant
pageflow_next_url: contributing.html
pageflow_next_text: Contributing
---
# CHANGELOG

## develop branch

### New

* Added support for Checks
  - added `Check` interface
  - added `ListCheck` interface
  - added `BadCheck` exception
  - added `BadCheckArgs` exception
  - added `BadChecksList` exception
  - added `EmptyChecksList` exception
  - added `ComposableCheck`
  - added `IsAllOf`
  - added `RequireValidChecks`

### Fixes

* Stop reusing `BadXXX` exceptions when we're reporting problems with a `callable`
  - added `BadCallable` exception
  - `ComposableAssurance` now throws `BadCallable` instead of `BadAssurance`
  - `ComposableRequirement` now throws `BadCallable` instead of `BadRequirement`

## v1.2016081301

### New

* Tweaks and changes to improve readabilty of your code
  - added `Inspection::inspect()` as an alias for `Inspection::to()`
  - added `InvokeableAssurable::inspect()`
  - added `InvokeableRequirement::inspect()`
* Added support for applying assurances and requirements to all elements in a list
  - added `ListInspection` interface
  - added `ListAssurance` interface
  - added `ListRequirement` interface
  - added `ListableAssurance` trait
  - added `ListableAssurance` trait
  - `ComposableAssurance` now implements `ListAssurance` interface
  - `ComposableRequirement` now implements `ListRequirement` interface
  - `EnsureAllOf` now implements `ListAssurance` interface
  - `EnsureAllOf` now accepts empty lists of assurances
  - `EnsureAnyOneOf` now implements `ListAssurance` interface
  - `EnsureAnyOneOf` now accepts empty lists of assurances
  - `RequireAllOf` now implements `ListRequirement` interface
  - `RequireAllOf` now accepts empty lists of requirements
  - `RequireAnyOneOf` now implements `ListRequirement` interface
  - `RequireAnyOneOf` now accepts empty lists of requirements
* A couple of internal classes are now `ListRequirement`s only
  - `RequireValidAssurances` is now a `ListRequirement`
  - `RequireValidRequirements` is now a `ListRequirement`
* Tweaks to improve usefulness of exceptions
  - `BadAssurance` exception message now includes the type of the bad assurance
  - `BadRequirement` exception message now includes the type of the bad requirement

## v1.2016062801

### New

* Added support for _assurances_: checks on return values and generated data values
  - added `BadAssurance` exception
  - added `BadAssuranceArgs` exception
  - added `BadAssurancesList` exception
  - added `EmptyAssurancesList` exception
  - updated `DefensiveExceptions` with the new exception factories
  - added `Assurance` interface
  - added `Inspection` interface
  - `Requirement` is now an `Inspection`
  - added `RequireValidAssurances`
  - added `ComposableAssurance`
  - added `InvokeableAssurance`
  - added `EnsureAllOf`
  - added `EnsureAnyOneOf`

## v1.2016061901

### Refactor

* Update everything to be compatible with the latest Exception Helpers library.
  - Update every class
  - Added `EmptyRequirementsList` exception

## v1.2016060601

Released Mon 6th June 2016.

### Fixes

* Support overriding default exceptions factory list
  - Updated `RequireAllOf`
  - Updated `RequireAnyOneOf`

## v1.2016060501

Released Sun 5th June 2016.

### Fixes

* Updated to support removal of `FilterCodeCaller::$DEFAULT_PARTIALS` from `ganbarodigital/php-mv-exception-helpers`

## v1.2016052101

Released Sat 21st May 2016.

* initial release
* feature release

### New

* Added a way to catch all exceptions thrown by this library
  - Added `DefensiveException` interface
* Added generic exceptions that this library will want to throw
  - Added `UnsupportedType` exception
  - Added `UnsupportedValue` exception
* Added a way to apply a list of requirements to a piece of data
  - Added `Requirement` interface
  - Added `InvokeableRequirement` convenience trait
  - Added `RequireAllOf` customisable function object
  - Added `RequireAnyOneOf` customisable function object
  - Added `RequireValidRequirements` customisable function object
  - Added `BadRequirement` exception
  - Added `BadRequirements` exception
  - Added `BadRequirementArgs` exception
* Added a way to make any `callable` into a `Requirement`
  - Added `ComposableRequirement` customisable function object
* Added a factory container for this library's methods
  - Added `DefensiveExceptions` DI container
* Added support for catching impossible logic errors
  - Added `UnreachableCodeExecuted` exception
