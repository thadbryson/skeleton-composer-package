# Composer Boilerplate

This is a template for creating Composer libraries.


## Getting Started

1. Copy this directory to a new one.
2. Change any settings in composer.json you need.
3. Change the Git remote origin. This way your new project won't be registered as this one.
    `git remote origin remove`
    `git remote origin add -- new origin --`
4. Delete files specific to this project
    - docs/LICENSE
    - Any .gitkeep files if those directories will no longer be empty.
    - TODO.md
    - composer.json
    - .gitignore
    - README.md
5. Rename files so they are active in your project.
    - composer.json.example to composer.json
    - README.md.example to README.md
    - gitignore.example to .gitignore
6. Run `composer install`


## What's included

```
root/
├── bin/        # For any executable scripts.
│   ├-- codeclimate      # Bash script for running Code Climate.
├── docker/     # Docker setup for your project. Optional. Read up on Docker for information on each directory and file.
├── docs/       # Documentation for your project.
│   ├── LICENSE # Creative Commons license for documentation of this project.
└── src/        # Source code.
    ├── .gitkeep
    ├ .gitignore
    ├ composer.json
    ├ composer.json.example    # Example for composer.json   
    ├ gitignore.example        # Example for .gitignore
    ├ LICENSE-code             # License for code of this project. 
    ├ LICENSE-docs             # License for docs of this project. 
    ├ README.md                # Project's README
    ├ README.md.example        # Example of a README file.
    ├ TODO.md                  # List of TODOs for this project.                     
```


## Integrate - [https://codeclimate.com/](Code Climate)

Code Climate is a project that analyzes your code. It can check that you're following certain coding practices. Like PSR-1 and PSR-2, 
you're using spaces instead of tabs, etc. It will flag any style violations. They're high powered linters.

I have included a Code Climate bash script. `bin/codeclimate`  It's useful for running Code Climate. I've had problems 
getting it to run on my machine without having to run docker run codeclimate/codeclimate every time. That's really annoying. 
So I created that handy script for myself.

Run the command `./bin/codeclimate` to get a list of commands.


From there you can install other engines to check your code.


## Integrate - [http://codeception.com/](Codeception)

I prefer to use Codeception. It's a great project that uses PHPUnit and some other custom libraries. With it you can use just basic PHPUnit which 
is usually all you ever need but it sets it all up nicely. 

If you ever need more features like a database for testing you can do that. You install it through Composer. It's listed as one of the 
suggested projects in the composer.json.example file. After you do a `composer install` the project will be in the vendor/ directory and a script 
in vendor/bin/.

Run the command `./vendor/bin/codecept` to get a list of commands.

I do prefer this over using just PHPUnit. And it has PHPUnit baked into it. So I'm not going to spend my time explaining how to integrate PHPUnit. Doing that is simple enough.


## Integrate - [https://www.docker.com/](Docker)

Docker is a huge thing these days. I've included scripts to get it going under the `docker/` directory. It has a helpful bash script `./docker/ctl`. 

Run the command `./dock` (from the ./docker directory) to get a list of commands.

Note: you need to set the container names in `./docker/docker-compose.yml`. 

When you get Docker setup for this project you can run your PHP code (or whatever code) from the container. Just SSH into it.

```
./dock ssh <container name>        # SSH into container
./dock ssh-root <container name>   # SSH into container as root
```


## Creators

**Thad Bryson**

- <https://twitter.com/ThadBry>
- <https://github.com/thadbryson>


## Copyright and license

Code and documentation copyright 2016 Thad Bryson. 

Code released under [the MIT license](https://github.com/thadbryson/composer-boilerplate/blob/master/LICENSE-code). 
Docs released under [Creative Commons](https://github.com/thadbryson/composer-boilerplate/blob/master/docs/LICENSE-docs).
