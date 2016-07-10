---
currentSection: v1
currentItem: assurance
pageflow_next_url: ComposableAssurance.html
pageflow_next_text: ComposableAssurance class
---

# Assurances

## Purpose

These are utilities for:

* an interface for assurances to implement
* applying groups of assurances to the same data

## Available Interfaces

Interface | Description
------|------------
[`Assurance`](../Interfaces/Assurance.html) | interface for all assurances to implement

Click on the name of an interface to see full details.

## Available Classes

Class | Description
------|------------
[`ComposableAssurance`](ComposableAssurance.html) | convert a partial assurance into one that could be composable
[`EnsureAllOf`](EnsureAllOf.html) | a value must meet all the assurances in the list
[`EnsureAnyOneOf`](EnsureAnyOneOf.html) | a value must meet at least one of the assurances in the list
[`InvokeableAssurance`](InvokeableAssurance.html) | convenience trait to provide the `__invoke()` method of the `Assurance` interface
[`ListableAssurance`](ListableAssurance.html) | convenience trait to provide the `toList()` and `inspectList()` methods of the `ListAssurance` interface

Click on the name of a class to see full details.
