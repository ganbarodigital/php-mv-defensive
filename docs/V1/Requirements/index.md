---
currentSection: v1
currentItem: requirements
pageflow_next_url: ComposableRequirement.html
pageflow_next_text: ComposableRequirement class
---

# Requirements

## Purpose

These are utilities for:

* an interface for requirements to implement
* applying groups of requirements to the same input data

## Available Interfaces

Interface | Description
------|------------
[`Requirement`](../Interfaces/Requirement.html) | interface for all requirements to implement

Click on the name of an interface to see full details.

## Available Classes

Class | Description
------|------------
[`ComposableRequirement`](ComposableRequirement.html) | convert a partial requirement into one that could be composable
[`InvokeableRequirement`](InvokeableRequirement.html) | convenience trait to provide the `__invoke()` method of the `Requirement` interface
[`RequireAllOf`](RequireAllOf.html) | a value must meet all the requirements in the list
[`RequireAnyOneOf`](RequireAnyOneOf.html) | a value must meet at least one of the requirements in the list
[`RequireValidAssurances`](RequireValidAssurances.html) | a value must be a list of assurances
[`RequireValidRequirements`](RequireValidRequirements.html) | a value must be a list of requirements

Click on the name of a class to see full details.
