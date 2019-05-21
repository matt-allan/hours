# Tags

Tags are used to keep track of related tasks across projects. A freelancer might use a different project for each client but keep track of what kind of work they are doing with tags like billing, coding, design, etc.

When you create a frame with the `start` or `add` command you can specify tags with the `--tag` option. You can add as many tags as you like by repeating the option. For example, you could add both the "coding" and "design" tags like this:

```
hours start --tag coding --tag design
```

Reports can be filtered with the `--tag` option.

To view all of the tags use the `tag:list` command.

A tag can be renamed using the `tag:rename` command.  The rename command takes two arguments: the old name and the new name.

```
$ php hours tag:rename code coding
Tag renamed.
```

A tag can be deleted using the `tag:forget` command.  Deleting a tag will remove the tag from any existing frames.
