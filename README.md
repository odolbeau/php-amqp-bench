# PHP amqp bench

Comparison between [php-amqp
library](https://github.com/videlalvaro/php-amqplib) and [php-amqp
extension](https://github.com/pdezwart/php-amqp).

## Installation

    composer install

## Usage

To test with 1000 messages:

    make extension 1000
    make lib 1000
