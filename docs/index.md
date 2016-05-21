---
currentSection: overview
currentItem: home
pageflow_next_url: license.html
pageflow_next_text: License
---

# Introduction

## What Is The Defensive Library?

Ganbaro Digital's _Defensive Library_ provides an easy-to-use collection of helpers that you can use to improve the robustness of your own code.

## Goals

The _Defensive Library_'s purpose is to collect robustness tools and approaches.

If you're looking to check your code's correctness, you'll want our [Contracts Library](https://ganbarodigital.github.io/php-mv-contracts).

## Design Constraints

The library's design is guided by the following constraint(s):

* _Fundamental dependency of other libraries_: This library provides robustness tests for other libraries to use in production. Composer does not support multual dependencies (two or more packages depending on each other). As a result, this library needs to depend on very little (if anything at all).

## Questions?

This package was created by [Stuart Herbert](http://www.stuartherbert.com) for [Ganbaro Digital Ltd](http://ganbarodigital.com). Follow [@ganbarodigital](https://twitter.com/ganbarodigital) or [@stuherbert](https://twitter.com/stuherbert) for updates.
