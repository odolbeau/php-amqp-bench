<?php

use Swarrot\Processor\ProcessorInterface;
use Swarrot\Broker\Message;

class Processor implements ProcessorInterface
{
    public function process(Message $message, array $options)
    {
        
    }
}

$connection = new \AMQPConnection();
$connection->connect();
$channel = new \AMQPChannel($connection);
$queue = new \AMQPQueue($channel);
$queue->setName('global');

$messageProvider = new PeclPackageMessageProvider($queue);

$consumer = new Consumer($messageProvider, new Processor());
$consumer->consume();
