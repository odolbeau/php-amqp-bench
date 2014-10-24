#!/usr/bin/env php

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

if (!isset($argv[2])) {
    throw new \BadFunctionCallException('Second argument must be the number of messages to publish');
}

$nb = $argv[2];

$connection = new AMQPConnection('127.0.0.1', 5672, 'guest', 'guest', 'bench');
$channel = $connection->channel();

for ($i = 0; $i < $nb; $i++) {
    $channel->basic_publish(new AMQPMessage("message$i"), 'bench');
}
