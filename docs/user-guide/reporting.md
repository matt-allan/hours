---
layout: default
title: Reporting
parent: User Guide
nav_order: 3
---

# Reporting

## Overview

You can view all of your frames with the `report` command.

```
$ hours report
May 1, 2019 to May 21, 2019
+---------+---------+--------------------------+-------------+----------+----------+---------+
| Project | Tags    | Notes                    | Date        | Start    | End      | Elapsed |
+---------+---------+--------------------------+-------------+----------+----------+---------+
| blog    | writing | Updating the about page  | May 7, 2019 | 12:26 pm | 1:26 pm  | 1:00    |
| blog    |         | Adding missing redirects | May 9, 2019 | 12:26 pm | 12:41 pm | 0:15    |
+---------+---------+--------------------------+-------------+----------+----------+---------+
Total hours: 1:15
```

By default the report will show time tracked thus far this month in text format.

## Date Ranges

To change the date range for the report use the `--from` and `--to` options.

```
$ hours report --from '2019-05-06' --to '2019-05-10'
May 6, 2019 to May 8, 2019
+---------+---------+-------------------------+-------------+----------+---------+---------+
| Project | Tags    | Notes                   | Date        | Start    | End     | Elapsed |
+---------+---------+-------------------------+-------------+----------+---------+---------+
| blog    | writing | Updating the about page | May 7, 2019 | 12:26 pm | 1:26 pm | 1:00    |
+---------+---------+-------------------------+-------------+----------+---------+---------+
Total hours: 1:00
```

Sometimes it's more convenient to specify an interval instead of the `--to` date. You can do this using the `--interval` option.

```
$ php hours report --from '2019-05-06' --interval '2 days'
May 6, 2019 to May 8, 2019
+---------+---------+-------------------------+-------------+----------+---------+---------+
| Project | Tags    | Notes                   | Date        | Start    | End     | Elapsed |
+---------+---------+-------------------------+-------------+----------+---------+---------+
| blog    | writing | Updating the about page | May 7, 2019 | 12:26 pm | 1:26 pm | 1:00    |
+---------+---------+-------------------------+-------------+----------+---------+---------+
Total hours: 1:00
```

## Output Formats

You can view the report as CSV or JSON instead by using the `--format` option.  The report is always printed to STDOUT. Use a [pipe](https://en.wikipedia.org/wiki/Pipeline_%28Unix%29) to save it to a file.

```
$ hours report --format csv > ~/Desktop/timesheet.csv
```

## Filters

Reports can be filtered by project and tag.

```
$ hours report --tag writing --project blog
May 1, 2019 to May 21, 2019
+-------------------------+-------------+----------+---------+---------+
| Notes                   | Date        | Start    | End     | Elapsed |
+-------------------------+-------------+----------+---------+---------+
| Updating the about page | May 7, 2019 | 12:26 pm | 1:26 pm | 1:00    |
+-------------------------+-------------+----------+---------+---------+
Total hours: 1:00
```
