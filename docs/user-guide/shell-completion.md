---
layout: default
title: Shell Completion
parent: User Guide
nav_order: 7
---

# Shell Completion

The Hours CLI ships with support for shell completion. Once completion is installed you can start typing and press tab at anytime to see the possible arguments or options.

It's possible to complete command names, options, arguments, projects, and tags.

Currently completion is only supported for the Bash and Zsh shells.

## Installation

To enable completion you must first register a completion hook for your shell. The following command will generate a completion script for your current shell and dump it to `STDOUT`:

```
$ hours _completion -g 
function _hours_b8d60942c7ecc176_complete {
    # many lines of shell code...
```

The `_completion` command will guess your shell type automatically. If the shell type was guessed incorrectly you can specify the shell with the `--shell-type` option.

The completion script should be piped to a file that will be automatically loaded by your shell. The exact location depends on your shell and how your machine is configured.

Bash completions are typically stored in `/etc/bash_completion.d` or `/usr/local/etc/bash_completion.d`.  Zsh completions are typically stored in `/usr/local/share/zsh/site-functions/`.

The following example shows how to create a completion script for Bash and Zsh using common paths for a MacOS machine:

```
# Bash
$ hours _completion -g > /usr/local/etc/bash_completion.d/hours
```

```
# Zsh
$ hours _completion -g > /usr/local/share/zsh/site-functions/_hours
```
