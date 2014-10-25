# PHP amqp bench

Comparison between [php-amqp
library](https://github.com/videlalvaro/php-amqplib) and [php-amqp
extension](https://github.com/pdezwart/php-amqp).

## Installation

Use composer to install dependencies:

    composer install

You probably want to initialize the `bench` RabbitMQ vhost which is used to
make this bench:

    ./prepare_rabbit.sh

## Usage

You can launch `./bench` to have a complete list of all available commands.
