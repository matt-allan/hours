# Internals

## Introduction

Hours is written in PHP with the [Laravel Zero framework](https://laravel-zero.com).  The application uses many of the features of the full [Laravel framework](https://laravel.com), including the console, Eloquent ORM, filesystem, and service container.  You should review the documentation for both projects before diving in.

### Timezone

The timezone is the only configuration that cannot be reliably set to a default.  Most users will set the PHP timezone to UTC.  Because of this we cannot determine the appropriate timezone automatically.

An event subscriber checks if the timezone is set at boot.  If the timezone is not set the user will be prompted to select their timezone.  This listener does it's best to guess the current timezone using a shell command, but we confirm that the choice is correct before continuing.  This functionality is disabled outside of development.

## Database

All of the data is stored in a sqlite database.  Interaction with the database is done via the Eloquent ORM.

You can open the database using the `sqlite3` command for debugging purposes:

```console
$ sqlite3 ./database/database.sqlite
SQLite version 3.28.0 2019-04-16 19:49:53
Enter ".help" for usage hints.
sqlite> 
```

To delete the database simply delete the file.

When the application boots an event listener will check if the database exists.  If not it will be created.  If any migrations need to be run they will be ran automatically.

During tests an in memory database is used instead.

## Dates & Times

All dates and times are handled using the [Carbon library](https://carbon.nesbot.com).  We use the `CarbonImmutable` class instead of the `Carbon` class as immutability helps prevent common bugs in the application code.

All times are stored in the database in UTC and converted to the user's current timezone for display.  When dates are accepted as input they are converted from the user's current timezone to UTC.

We register a few macros & mixins to make working with dates easier.  You can view these macros & mixins in the `AppServiceProvider`.

[^1]: The `XDG_CONFIG_HOME` environment variable is defined by the [XDG Base Directory Specification](https://specifications.freedesktop.org/basedir-spec/basedir-spec-latest.html).  On most Mac and Linux computers this defaults to `~/.config`.

