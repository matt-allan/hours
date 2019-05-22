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
