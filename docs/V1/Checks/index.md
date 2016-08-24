---
currentSection: v1
currentItem: checks
pageflow_next_url: ComposableCheck.html
pageflow_next_text: ComposableCheck class
---

# Checks

## Purpose

These are utilities for performing `true` / `false` inspections of data.

## Available Interfaces

Interface | Description
------|------------
[`Check`](../Interfaces/Check.html) | interface for all checks to implement
[`ListCheck`](../Interfaces/ListCheck.html) | interface for all inspections that check lists of data to implement

Click on the name of an interface to see full details.

## Available Classes

Class | Description
------|------------
[`ComposableCheck`](ComposableCheck.html) | convert any callable into a `Check` that is composable
[`IsAllOf`](IsAllOf.html) | a value must pass all of the checks in the list
[`IsAnyOneOf`](IsAnyOneOf.html) | a value must pass at least one of the checks in the list
[`ListableCheck`](ListableCheck.html) | convenience trait to provide the `toList()` and `inspectList()` methods of the `ListCheck` interface

Click on the name of a class to see full details.
