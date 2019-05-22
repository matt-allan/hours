---
layout: default
title: Time Tracking
parent: User Guide
nav_order: 2
---

# Time Tracking

## Starting

To begin tracking time use the `start` command.  You can specify the name of the project to track time for as well as any tags or notes you would like to add.

The following command will begin tracking time and create a new **frame** for the "blog" project.  The frame has the "writing" tag and a note.

```
$ hours start blog --tag writing --notes 'Updating the about page'
Starting frame for blog (writing) at 12:26 pm
```

Sometimes you forget to punch in.  That's ok, just use the `--at` option to specify the start time.

```
$ hours start blog --at '15 minutes ago'
Starting frame for blog at 12:26 pm
```

## Checking the status

We can confirm that time tracking is active with the `status` command.

```
$ hours status
Time tracking for blog started 4 seconds ago.
```

## Stopping

Once you have finished your task you can stop tracking time with the `stop` command.


```
$ hours stop
Time tracking for blog stopped (started 1 hour ago).
```

## Cancelling

If you need to cancel the active frame you can use the `cancel` command. The `cancel` command deletes the active frame.

```
$ hours cancel
Time tracking for blog cancelled (started 3 seconds ago).
```

## Restarting

The `restart` command can be used to restart the last frame. Rather than edit the existing a frame a new frame is created with the same project, tags, and notes as the last frame.

```
$ hours restart
Restarting frame for blog at 7:04 pm
```

## Adding frames

Sometimes you forget to track something and need to add a frame after the fact. You can do this using the `add` command.

You can specify the start and end times with the `--from` and `--to` options.

```
$ hours add blog --from '2019-05-01 2:00 PM' --to '2019-05-01 3:00 PM'
Added frame for blog from May 1, 2019 2:00 pm to May 1, 2019 3:00 pm (1 hour).
```

If you don't know the end time but you know how long you worked you can use the `--interval` option instead.

```
hours add blog --from '2019-05-01 2:00 PM' --interval '2 hours'
Added frame for blog from May 1, 2019 2:00 pm to May 1, 2019 4:00 pm (2 hours).
```

Just like the `start` command you can specify tags (`--tag`) or notes (`--note`).
