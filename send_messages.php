#!/usr/bin/env php

<?php

require_once __DIR__ . '/vendor/autoload.php';

if (!isset($argv[1])) {
    throw new \BadFunctionCallException('First argument must be the number of messages to publish');
}

$nb = $argv[1];

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
