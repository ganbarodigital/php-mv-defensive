---
currentSection: v1
currentItem: exceptions
pageflow_next_url: BadRequirement.html
pageflow_next_text: BadRequirement class
---

# Exceptions

## Purpose

These are the exceptions that this library can throw.

## Exceptions List

Class | Description
------|------------
[`BadRequirement`](BadRequirement.html) | thrown when you pass something that isn't a requirement into one of the [Requirements](../Requirements/index.html) classes
[`BadRequirements`](BadRequirements.html) | thrown when you pass something that isn't a requirements list into one of the [Requirements](../Requirements/index.html) classes
[`BadRequirementArgs`](BadRequirementArgs.html) | thrown when you pass something that isn't a list of arguments into one of the [Requirements](../Requirements/index.html) classes
[`UnsupportedType`](UnsupportedType.html) | thrown when you pass the wrong data type into one of the [Requirements](../Requirements/index.html) classes
[`UnsupportedValue`](UnsupportedValue.html) | thrown when you pass in a parameter that has the right data type, but a value that can't be accepted

## Exceptions Container

[`DefensiveExceptions`](DefensiveExceptions.html) provides a full list of exception factories as a [`FactoryList`](http://ganbarodigital.github.io/php-mv-di-containers/V1/Interfaces/FactoryList.html).

Click on the name of an exception to see full details.
