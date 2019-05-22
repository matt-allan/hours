# Hours

A minimal CLI for tracking time.  Easily track the time you spend on personal tasks or client projects.  Generate beautiful reports.

All your data is yours and yours only - we never send any data to the cloud or a remote server.

[![asciicast](https://asciinema.org/a/245508.svg)](https://asciinema.org/a/245508)

## Quick Start

## Installation

Hours is written in PHP. You will need a PHP version >= 7.1.3. You can check this easily with the `php --version` command.

If you have PHP installation you can easily download the executable from Github:

```
wget https://github.com/matt-allan/hours/releases/download/0.1.0/hours -O hours
sudo chmod a+x hours
sudo mv hours /usr/local/bin/hours
```

## Usage

To begin tracking time use the `start` command. You can specify the name of the project to track time for, as well as any tags or notes you would like to add.

```
$ hours start blog --tag writing --notes 'Updating the about page'
Starting frame for blog (writing) at 12:26 pm
```

This will create a "frame". Once you have finished your task you can stop tracking time with the `stop` command.

```
$ hours stop                                                      
Time tracking for blog stopped (started 1 hour ago).
```

You can view all of your frames with the `report` command.

```
$ hours report                                      
May 1, 2019 to May 7, 2019
+---------+---------+-------------------------+-------------+----------+----------+---------+
| Project | Tags    | Notes                   | Date        | Start    | End      | Elapsed |
+---------+---------+-------------------------+-------------+----------+----------+---------+
| blog    | writing | Updating the about page | May 7, 2019 | 12:26 pm | 1:26 pm  | 1:00    |
+---------+---------+-------------------------+-------------+----------+----------+---------+
Total hours: 1:00
```

That should be enough information to get you started. To learn more check out the [user guide](https://matt-allan.github.io/hours/user-guide).

## Contribute

Are you interested in helping out with development? Check out our [contributor's guide](./docs/contributing) to get started.

## License

Hours is released under the MIT License. See the bundled [LICENSE](./LICENSE.md) file for details.
