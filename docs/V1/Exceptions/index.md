---
currentSection: v1
currentItem: exceptions
pageflow_next_url: BadAssurance.html
pageflow_next_text: BadAssurance class
---

# Exceptions

## Purpose

These are the exceptions that this library can throw.

## Exceptions List

### Assurance Exceptions

Class | Description
------|------------
[`BadAssurance`](BadAssurance.html) | thrown when you pass something that isn't an assurnace into one of the [Assurance](../Assurances/index.html) classes
[`BadAssuranceArgs`](BadAssuranceArgs.html) | thrown when you pass something that isn't a list of arguments into one of the [Assurance](../Assurances/index.html) classes
[`BadAssurancesList`](BadAssurancesList.html) | thrown when you pass something that isn't a list of assurances into one of the [Assurance](../Assurances/index.html) classes
[`EmptyAssurancesList`](EmptyAssurancesList.html) | thrown when you pass an empty list into one of the [Assurance](../Assurances/index.html) classes

### Check Exceptions

Class | Description
------|------------
[`BadCheckArgs`](BadCheckArgs.html) | thrown when you pass something that isn't a list of arguments into one of the [Check](../Checks/index.html) classes

### Requirements Exceptions

Class | Description
------|------------
[`BadRequirement`](BadRequirement.html) | thrown when you pass something that isn't a requirement into one of the [Requirements](../Requirements/index.html) classes
[`BadRequirements`](BadRequirements.html) | thrown when you pass something that isn't a requirements list into one of the [Requirements](../Requirements/index.html) classes
[`BadRequirementArgs`](BadRequirementArgs.html) | thrown when you pass something that isn't a list of arguments into one of the [Requirements](../Requirements/index.html) classes
[`EmptyRequirementsList`](EmptyRequirementsList.html) | thrown when you pass an empty requirements list into one of the [Requirements](../Requirements/index.html) classes

### Other Exceptions

Class | Description
------|------------
[`BadCallable`](BadCallable.html) | thrown when you pass a non-callable into something that is expecting a valid PHP `callable`
[`UnreachableCodeExecuted`](UnreachableCodeExecuted.html) | thrown when `switch` or `if` / `else` logic reaches a branch that should never be reached
[`UnsupportedType`](UnsupportedType.html) | thrown when you pass the wrong data type into one of the [Requirements](../Requirements/index.html) classes
[`UnsupportedValue`](UnsupportedValue.html) | thrown when you pass in a parameter that has the right data type, but a value that can't be accepted

## Exceptions Container

[`DefensiveExceptions`](DefensiveExceptions.html) provides a full list of exception factories as a [`FactoryList`](http://ganbarodigital.github.io/php-mv-di-containers/V1/Interfaces/FactoryList.html).

Click on the name of an exception to see full details.
