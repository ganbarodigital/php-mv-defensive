---
currentSection: v1
currentItem: home
pageflow_next_url: Exceptions/index.html
pageflow_next_text: Exceptions
---

# Version 1.x

## Introduction

Version 1 was written to replace `ganbarodigital/php-defensive`. It offers pretty much the same functionality as that library did, just with an improved interface.

## Key Ideas

The key ideas in Version 1 are:

* `Requirement::apply()->to()` pattern - apply the requirement to a value. If the requirement isn't met, throw an exception.
* _composable requirements_ - each `Requirement` now takes one parameter (the value being checked). This allows us to build lists of requirements to apply to a value.

## Components

Version 1 ships with the following components:

Namespace | Purpose
----------|--------
[`GanbaroDigital\Defensive\V1\Exceptions`](Exceptions/index.html) | exceptions thrown by this library
[`GanbaroDigital\Defensive\V1\Interfaces`](Interfaces/index.html) | interfaces defined by this library
[`GanbaroDigital\Defensive\V1\Requirements`](Requirements/index.html) | enforce robustness checks

Click on the namespace to learn more about the classes in that component.
