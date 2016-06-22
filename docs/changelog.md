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

* Added support for _assurances_: checks on return values and generated data values
  - added `BadAssurance` exception
  - added `BadAssuranceArgs` exception
  - added `BadAssurancesList` exception
  - added `EmptyAssurancesList` exception
  - updated `DefensiveExceptions` with the new exception factories

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
