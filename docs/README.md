# Hours Documentation

This folder contains the documentation for the Hours project.

## Overview

The hours documentation is written in [markdown](https://www.markdownguide.org) and hosted with [Github pages](https://pages.github.com). The HTML is built with [Jekyll](https://jekyllrb.com).

## Contributing

The easiest way to contribute is to [edit the file directly on Github](https://help.github.com/en/articles/editing-files-in-your-repository) and create a pull request.

Alternatively you can checkout the repository locally.  See the [contributor docs](https://matt-allan.github.io/hours/contributing/) for more info.

## Building

To build the site locally you will need a ruby development environment and the [bundler gem](https://jekyllrb.com/docs/ruby-101/#bundler). Follow the [Jekyll documentation](https://jekyllrb.com/docs/installation/) to get started.

Next execute the following commands from the `docs` folder of this repository.

```
bundle install
bundle exec jekyll serve
```

## Adding Pages

All pages need to begin with [front matter](https://jekyllrb.com/docs/front-matter/) so they will be processed with Jekyll. See an existing file for an example.

There are a few special front matter parameters (`nav_order`, `has_children`, etc.) used for navigation. See the [documentation for our Jekyll theme](https://pmarsceill.github.io/just-the-docs/docs/navigation-structure/) to learn more.
