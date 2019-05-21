# Internals

## Introduction

Hours is written in PHP with the [Laravel Zero framework](https://laravel-zero.com).  The application uses many of the features of the full [Laravel framework](https://laravel.com), including the console, Eloquent ORM, filesystem, and service container.  You should review the documentation for both projects before diving in.

## Console

The `hours` CLI is bootstrapped by a PHP script in the project root.  You can run the CLI like this:

```
$ php hours --version
Hours 0.1.0
```

Alternatively on Unix systems you can execute the script directly.  The script will be executed with PHP because of the [shebang](https://en.wikipedia.org/wiki/Shebang_(Unix)) at the top of the file.

```
$ ./hours --version
Hours 0.1.0
```

Production builds are packed into a [PHP Archive](https://www.php.net/manual/en/intro.phar.php) and moved to the user's [PATH](https://en.wikipedia.org/wiki/PATH_(variable), allowing the CLI to be invoked directly.

```
hours --version
```

It's important to note that executing `hours` directly will **always** use the phar in your PATH. During development you should always use `php hours` or `./hours` to ensure you are running the development code.

### Timezone

The timezone is the only configuration that cannot be reliably set to a default.  Most users will set the PHP timezone to UTC.  Because of this we cannot determine the appropriate timezone automatically.

An event subscriber checks if the timezone is set at boot.  If the timezone is not set the user will be prompted to select their timezone.  This listener does it's best to guess the current timezone using a shell command, but we confirm that the choice is correct before continuing.  This functionality is disabled during development because it's annoying and can cause tests to hang forever waiting for input.

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

During development the database is stored at `database/database.sqlite`.  Production builds will store the database in `$XDG_DATA_HOME/Hours/database.sqlite` [^1].  During tests an in memory database is used.

## Dates & Times

All dates and times are handled using the [Carbon library](https://carbon.nesbot.com).  We use the `CarbonImmutable` class instead of the `Carbon` class as immutability helps prevent common bugs in the application code.

All times are stored in the database in UTC and converted to the user's current timezone for display.  When dates are accepted as input they are converted from the user's current timezone to UTC [^2].

We register a few macros & mixins to make working with dates easier.  You can view these macros & mixins in the `AppServiceProvider`.

[^1]: The `XDG_DATA_HOME` environment variable is defined by the [XDG Base Directory Specification](https://specifications.freedesktop.org/basedir-spec/basedir-spec-latest.html).  On most Mac and Linux computers this defaults to `~/.local/share`.

[^2]: Eventually it would probably be best to store the timezone that was active at the time the frame was created.  This would allow a user to record a frame from 9-5 in PST, then view a report in EST and see 9-5 (the time they actually recorded the frame in PST) instead of 1-9 (the time it would have been in EST).
