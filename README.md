# Composer Boilerplate

This is a template for creating Composer libraries.


## Getting Started

1. Copy `dist/` directory to your new project directory.
2. Change any settings in composer.json you need.
3. Change the Git remote origin.
    `git remote origin remove`
    `git remote origin add -- new origin --`
4. Delete the composer.lock if you have one.
5. Run `composer install`
6. Write my own README.md file?
7. Change this file with my own TODO list?


## What's included in dist/

```
root/
├── dist/
    ├── docs/ <-- This is where your project documentation can go.
    ├── src/  <-- This is where your project source code can go.

    ├ composer.example.json         # Example for composer.json. Has most config settings available.
    ├ composer.example-mine.json    # Example composer.json file I use.
    ├ gitignore.example             # Example for .gitignore
    ├ README.md.example             # Example of a README file.
    ├ TODO.md                       # A file you can use to setup a TODO list for your project.
```

## Creators

**Thad Bryson**

- <https://twitter.com/ThadBry>
- <https://github.com/thadbryson>


## Copyright and license

Code and documentation copyright 2016 Thad Bryson.

Code released under [the MIT license](https://github.com/thadbryson/composer-boilerplate/blob/master/LICENSE-code).
Docs released under [Creative Commons](https://github.com/thadbryson/composer-boilerplate/blob/master/docs/LICENSE-docs).
