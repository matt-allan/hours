# Hours

A minimal CLI for tracking time.  Easily track the time you spend on personal tasks or client projects.  Generate beautiful reports.

All your data is yours and yours only - we never send any data to the cloud or a remote server.

[![asciicast](https://asciinema.org/a/245508.svg)](https://asciinema.org/a/245508)

## Installation

### Prerequisites

Hours is written in PHP.  You will need a PHP version >= `7.1.3`.  You can check this easily with the `php --version` command.  If you need to update or install PHP follow the [official documentation](https://www.php.net/manual/en/install.php).

### Standard

**NOTE:** This doesn't work yet - Hours is still under development.

The easiest way to install `hours` is to download the latest release.

```console
wget https://github.com/matt-allan/hours/releases/download/0.1/hours.phar -O hours
sudo chmod a+x hours
sudo mv hours /usr/local/bin/hours
```

### Composer

If you are a PHP developer you can install Hours with Composer.

```console
composer global require matt-allan/hours
```

You should confirm that the composer bin directory is in your `$PATH`.  Check the [official docs](https://getcomposer.org/doc/03-cli.md#global) for more info.

### Development

To install Hours for development you will need `php`, `git`, `sqlite`, and `composer`.

First clone the repository:

```console
git clone git@github.com:matt-allan/hours.git
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

It's a good idea to run the tests before you change anything.  You can do this easily with the `composer test` command.

```console
composer test
```

## Getting Started

To begin tracking time use the `start` command.  You can specify the name of the project to track time for, as well as any tags or notes you would like to add.

```console
$ hours start blog --tag writing --notes 'Updating the about page'
Starting frame for blog (writing) at 12:26 pm
```

This will create a 'frame'.  Once you have finished your task you can stop tracking time with the `stop` command.

```console
$ hours stop                                                      
Time tracking for blog stopped (started 1 hour ago).
```

You can view all of your frames with the `report` command.

```console
$ hours report                                      
May 1, 2019 to May 7, 2019
+---------+---------+-------------------------+-------------+----------+----------+---------+
| Project | Tags    | Notes                   | Date        | Start    | End      | Elapsed |
+---------+---------+-------------------------+-------------+----------+----------+---------+
| blog    | writing | Updating the about page | May 7, 2019 | 12:26 pm | 1:26 pm  | 1:00    |
+---------+---------+-------------------------+-------------+----------+----------+---------+
Total hours: 1:00
```

By default the report will show time tracked thus far this month in text format.  For a complete list of options check the help with `hours report --help`.

That should be enough information to get you started.  To learn more check out the [user guide](./docs);

## Contribute

Are you interested in helping out with development?  Check out our [contributor's guide](./.github/CONTRIBUTING.md) to get started.
