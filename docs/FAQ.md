---
layout: default
title: FAQ
nav_order: 3
permalink: /faq
---

# FAQ

## Where is my data stored?

All of your data is stored in a [sqlite3](https://sqlite.org/index.html) database. The database is located at the path `$XDG_DATA_HOME/Hours/database.sqlite`.

The `XDG_DATA_HOME` environment variable is defined by the [XDG Base Directory Specification](https://specifications.freedesktop.org/basedir-spec/basedir-spec-latest.html).  On most computers this defaults to `~/.local/share`, meaning your database is at `~/.local/share/Hours/database.sqlite`.

## I'm traveling and Hours is using the wrong timezone.  How do I change it?

You can change the current timezone with the [`settings:edit` command](/user-guide/settings).
