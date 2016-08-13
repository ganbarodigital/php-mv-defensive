---
currentSection: v1
currentItem: home
pageflow_next_url: Assurances/index.html
pageflow_next_text: Assurances
---

# Version 1.x

## Introduction

Version 1 was written to replace `ganbarodigital/php-defensive`. It offers pretty much the same functionality as that library did, just with an improved interface.

## Key Ideas

The key ideas in Version 1 are:

* _requirements_ (checks on inputs) and _assurances_ (checks on outputs and return values)
* `Assurance::apply()->to()` / `Requirement::apply()->to()` pattern - apply the assurance / requirement to a value. If the assurance / requirement isn't met, throw an exception.
* `ListAssurance::apply()->toList()` / `ListRequirement::apply()->toList()` pattern - apply the assurance / requirement to a list of values. If the assurance / requirement isn't met, throw an exception.
* _composable assurances and requirements_ - each `Assurance` / `Requirement` now takes one parameter (the value being checked). This allows us to build lists of assurances / requirements to apply to a value.

## Components

Version 1 ships with the following components:

Namespace | Purpose
----------|--------
[`GanbaroDigital\Defensive\V1\Assurances`](Assurances/index.html) | robustness checks for outputs and return values
[`GanbaroDigital\Defensive\V1\Exceptions`](Exceptions/index.html) | exceptions thrown by this library
[`GanbaroDigital\Defensive\V1\Interfaces`](Interfaces/index.html) | interfaces defined by this library
[`GanbaroDigital\Defensive\V1\Requirements`](Requirements/index.html) | robustness checks for inputs

Click on the namespace to learn more about the classes in that component.
