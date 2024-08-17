# PHP Retail Calculator Kata

Build a retail calculator software.

Kata from [Elephant Carpaccio exercise Facilitation guide - Henrik Kniberg & Alistair Cockburn, 2013-07-11](https://docs.google.com/document/d/1TCuuu-8Mm14oxsOnlk8DqfZAA1cvtYu9WGv67Yj_sSk/pub)

### Install dependencies and run tests

Install project dependencies with

```
$ ./composer.phar install
```

Run the tests with

```
$ ./composer.phar exec phpunit
$ ./composer.phar exec phpunit ./tests/SingleTest.php
$ ./composer.phar exec -- phpunit --filter someProductsInUtah
```

### Docker only dev setup

Create a temporary php7 container with mapped source folder and install minimal dependencies inside:

```
$ docker run --rm -it -v $PWD:/app -w /app php:7.3.14 bash
# apt-get update && apt-get install -y git libzip-dev && docker-php-ext-install zip
```

Composer commands can be now executed in the container:

```
# ./composer.phar install
# ./composer.phar exec ....
```

Alternatively build and use the custom image defined in the `Dockerfile`:

```
$ docker build -t retail-calculator .
$ docker run --rm -it -v $PWD:/app -w /app retail-calculator bash
# ./composer.phar install
# ./composer.phar exec ....
```

