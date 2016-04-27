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

* Added a way to catch all exceptions thrown by this library
  - Added `DefensiveException` interface
* Added generic exceptions that this library will want to throw
  - Added `UnsupportedType` exception
  - Added `UnsupportedValue` exception
* Added a way to apply a list of requirements to a piece of data
  - Added `Requirement` interface
  - Added `RequireAllOf` customisable function object
  - Added `RequireAnyOneOf` customisable function objects
  - Added `BadRequirement` exception
  - Added `BadRequirements` exception
  - Added `BadRequirementArgs` exception
