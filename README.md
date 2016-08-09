# Behat Partial Runner
Behat extension for distributing Scenarios across multiple worker nodes.

## Dependancies
This project is set up with docker to simplify handling dependencies. By using docker, you are not required to install any additional packages or resources on your system, regardless of what sources the project may end up using in the future. All you need is the Docker Engine. 
- [Docker Engine](https://docs.docker.com/engine/installation/)
- [Kitematic](https://kitematic.com/) (Optional)

## Setup
To get started, simply run the composer script included in the bin directory. This will use a Docker container to set up the project. There is no need to install composer.

```
> bin/composer install
```

## Usage
Once the setup is complete, usage is quite simple. Run the following in the project root diretory. Again this will use a docker container to execute the testing. You don't have to install PHPUnit.
```
<<<<<<< 085ccd3c641808945b378f039be1fb8b8bc43609
> bin/behat --help
> bin/phpunit
```

## Debugging
PHP is provided via a docker container as well. It supports all regular php commands

```
> bin/php -a
> bin/php script.php
> bin/php -v
```

# Full Command List
The following command scripts are provided to leverage Docker.

- `bin/behat`
  - Runs Behat version defined in the composer file in the php container
  - Supports all behat arguments
- `bin/composer`
  - Runs the latest PHP Composer
  - Supports all composer arguments.
- `bin/php`
  - Runs the latest php cli release
  - Supports all PHP CLI switches
- `bin/phpunit`
  - Runs the latest phpunit
  - Supports all PHPUnit switches
  - Will always use `--configuration=phpunit.xml`!`
