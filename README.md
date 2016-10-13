# Behat Partial Runner
The Partial Runner is a Behat extension which runs a subset of scenarios to parallelize Behat across mutliple nodes.

Where as [shvetsgroup/ParallelRunner](https://github.com/shvetsgroup/ParallelRunner) is an excellent tool for parallelizing Behat on a _single_ machine, it unfortunately does not handle parallelizing Behat _across multiple_ machines. The Behat Partial runner fills this gap.

It is _very_ useful for CI services which offer parallelization such as CircleCI and TravisCI.

## Usage
Require the extension with composer either through CLI or editing the `composer.json`.
```
> bin/composer require --dev taysirtayyab/behat-partial-runner:dev-master
```
```
"require-dev": {
  "taysirtayyab/behat-partial-runner": "dev-master"
}
```
 Then and the extension to your `behat.yml` file.
```
default:
  extensions:
    Behat\PartialRunner\ServiceContainer\PartialRunnerExtension: ~
```

Once configured, the parallelization can be invoked using the `--count-workers` and `--worker-number` options.

```
bin/behat --worker-number=0 --count-workers=2
bin/behat --worker-number=1 --count-workers=2
```

**Note:** The `--worker-number` expects a 0-indexed node index.

### CircleCI
To integrate with CircleCI, add the following to your `circle.yml` file.
```
tests:
    override: behat --worker-number=$CIRCLE_NODE_INDEX --count-workers=$CIRCLE_NODE_TOTAL:
        parallel: true
```

### TravisCI
To integerate with TravisCI, add the following to your `.travis.yml` file.
```
script:
    - behat --worker-number=$CI_NODE_INDEX --count-workers=$CI_NODE_TOTAL
env:
    global:
        - CI_NODE_TOTAL=2
    matrix:
        - CI_NODE_INDEX=0
        - CI_NODE_INDEX=1
```

## Development
This project is set up with docker to simplify handling dependencies. By using docker, you are not required to install any additional packages or resources on your system, regardless of what sources the project may end up using in the future. All you need is the [Docker Engine](https://docs.docker.com/engine/installation/).

### Setup
Once docker is installed, use the bundled script for composer to install the dependencies.

```
> bin/composer install
```

### Testing
Usage is quite simple. Use the bundled scripts out of the project root directory. These will use the bundled php script for the php docker container.
```
> bin/behat
> bin/phpunit
```
_(Adding `./bin` to you `$PATH` variable may be helpful.)_

