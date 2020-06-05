---
layout: default
title: Projects
parent: User Guide
nav_order: 4
---

# Projects

Projects are used to track time for different things.  A freelancer might have a project for every client they work on, while a student might have a project for each class they are taking.

You always have to specify a project when creating an entry.  You can then filter reports by project with the `--project` option.

To view all of the active projects use the `project:list` command.

A project can be renamed using the `project:rename` command.  The rename command takes two arguments: the old name and the new name.

```
$ php hours project:rename blarg blog
Project renamed.
```

A project can be deleted using the `project:forget` command.  **Deleting a project will delete all of it's frames.**

## Default Projects

If you're only using Hours to track time for a single project, you can set a default. The default project will be used if you don't specify the project argument. To specify a default project you may [set the `default_project` setting](./settings).

A common workflow is to track time for a given project when you're in that project's directory. For example, while working on the Hours codebase I'm working from the `~/code/hours` directory on my computer.

To specify the default project for a directory you can add a `.hours` file. The `.hours` file is a file containing environment variables for the Hours CLI. To specify the default project, set the `HOURS_PROJECT` environment variable to the project's name. A `.hours` file for a project named 'blog' would look like this:

```
HOURS_PROJECT=blog
```