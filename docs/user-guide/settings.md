---
layout: default
title: Settings
parent: User Guide
nav_order: 6
---

# Settings

There are a few settings you can change which determine the display of dates and times.

## Viewing

To view settings use the `settings:list` command. Only settings that are explicitly set to a non-default value will be listed.

```
$ hours settings:list
+----------+------------------+
| name     | value            |
+----------+------------------+
| timezone | America/New_York |
+----------+------------------+
```

## Editing

To change a setting use the `settings:edit` command. The `settings:edit` command takes two arguments: the name of the setting and the value to set.

```
$ hours settings:edit timezone America/Denver
Updated timezone to America/Denver
```

## Available Settings

- `timezone`: The timezone settings determines what timezone is used for input and display. All dates and times are stored internally as UTC. The timezone must be one of PHP's [supported timezones](https://www.php.net/manual/en/timezones.php).

- `date_format`: The date format setting determines the format used when displaying dates. The format string must be one of PHP's accepted [date format strings](https://www.php.net/manual/en/function.date.php). The default value is `F j, Y` which formats dates like this: `May 22, 2019`.

- `time_format`: The time format setting determines the format used when displaying times. The format string must be one of PHP's accepted [time format strings](https://www.php.net/manual/en/function.date.php). The default value is `g:i a` which formats times like this: `2:46 pm`.

- `interval_format`: The interval format setting determines the format used when displaying intervals. The format string must be one of PHP's accepted [interval format strings](https://www.php.net/manual/en/dateinterval.format.php). The default value is `%h:%I` which formats intervals like this: `2:00`.
