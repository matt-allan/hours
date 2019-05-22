---
layout: default
title: Contributing
nav_order: 2
has_children: true
permalink: /contributing
---

# Contributing

## Introduction

The Hours time tracker is open source software, written by [contributors](https://github.com/matt-allan/hours/graphs/contributors) from around the world.  We are always looking for new contributors.

The hours CLI is written in the [PHP programming language](https://www.php.net) with the [Laravel Zero](https://laravel-zero.com) framework. To contribute code you will need a basic understanding of PHP and [Git](https://git-scm.com).

## Setup

To install Hours for development you will need `php`, `git`, `sqlite`, and `composer`.

First [fork the repository](https://help.github.com/en/articles/fork-a-repo) on [Github](https://github.com/matt-allan/hours).

You will see a link to 'Clone or download' your fork.  Either open the link with Github Desktop or copy the URL into your terminal and clone the repo with git:

```console
git clone git@github.com:<your-username>/hours.git
```

Next change to the application directory and install composer dependencies:

```console
cd hours
composer install
```

Finally confirm the application works:

```console
php hours list
```

## Writing Code

The [internals](./internals) documentation explains how everything works and what you need to know to get started writing code.

## Writing Docs

We are always looking for contributors that would like to improve the documentation. The [documentation README](https://github.com/matt-allan/hours/blob/master/docs/README.md) covers everything you need to know about contributing to the docs.

## Project Management

All project management happens through our [Github Repo](https://github.com/matt-allan/hours). Collaboration happens through [projects](https://github.com/matt-allan/hours/projects), [issues](https://github.com/matt-allan/hours/issues), and [pull requests](https://github.com/matt-allan/hours/pulls).

If you are looking to get started have a look at our [starter issues](https://github.com/matt-allan/hours/issues?q=is%3Aissue+is%3Aopen+label%3A%22good+first+issue%22).

## Pull Requests

Make sure to read our [contributor guidelines](https://github.com/matt-allan/hours/blob/master/.github/CONTRIBUTING.md) before creating a pull request. The contributor guidelines cover everything you need to know about contributing code changes.

If something doesn't make sense don't worry — just open a pull request and we can walk you through it.

Feel free to open a pull request even if it's not ready to merge! Opening a pull request early makes it easy to collaborate — you can ask questions, get feedback, and let others know that you have started working on it. Github makes this easy with [draft pull requests](https://github.blog/2019-02-14-introducing-draft-pull-requests/).

## Releases

The release process is [documented](./releases) for maintainers.
