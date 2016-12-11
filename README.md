# Composer Boilerplate

This is a template for creating Composer libraries.


## Getting Started

1. Copy the `dist/` directory to a new one.
2. Change any settings in `composer.example.json` or `composer.example-mine.json`.
3. Change the Git remote origin. This way your new project won't be registered as this one.
    `git remote origin remove`
    `git remote origin add -- new origin --`
4. Setup your `composer.json` file. The example file you choose will have documentation for
settings to change.
5. Run `composer install` to being.


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
