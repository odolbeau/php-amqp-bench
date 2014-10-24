#!/usr/bin/env php

<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (!isset($argv[2])) {
    throw new \BadFunctionCallException('Second argument must be the number of messages to publish');
}

$nb = $argv[2];

$connection = new \AMQPConnection([
    'vhost' => 'bench'
]);
$connection->connect();
$channel = new \AMQPChannel($connection);
$exchange = new \AMQPExchange($channel);
$exchange->setName('bench');

for ($i = 0; $i < $nb; $i++) {
    $exchange->publish("message$i", 'bench');
}
