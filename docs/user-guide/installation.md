# Installation

## Prerequisites

### PHP

Hours is written in PHP. You will need a PHP version >= 7.1.3. You can check this easily with the `php --version` command.

```
$ php --version
PHP 7.3.3 (cli) (built: Mar  8 2019 16:40:07) ( NTS )
Copyright (c) 1997-2018 The PHP Group
Zend Engine v3.3.3, Copyright (c) 1998-2018 Zend Technologies
    with Zend OPcache v7.3.3, Copyright (c) 1999-2018, by Zend Technologies
```

If you need to update or install PHP follow the [official documentation](https://www.php.net/manual/en/install.php).

### Sqlite3

All time tracking data is stored in a [SQLite](https://sqlite.org) database. Your PHP installation will need to include the [SQLite extension](https://www.php.net/manual/en/book.sqlite.php).

If you see `sqlite3` listed in the output of `php -m` the extension is already installed. Otherwise follow the [official guide](https://www.php.net/manual/en/sqlite.installation.php) to install and enable it.

## Installing

The hours CLI is distributed as a [PHP Archive (phar)](https://www.php.net/manual/en/intro.phar.php).  To install it you just need to download the phar and move it to the directory you normally keep executables. On Mac and Linux systems this is typically the `/usr/local/bin` directory.

```
wget https://github.com/matt-allan/hours/releases/download/0.1.0/hours -O hours
sudo chmod a+x hours
sudo mv hours /usr/local/bin/hours
```


It's a good idea to verify the `hours` command is available before continuing.

```
$ hours --version
Hours 0.1.0
```

## Development Installation

If you are installing Hours for development you need to clone the repository instead.  See the [contributing guide](../contributing) for more info.
