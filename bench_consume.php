#!/usr/bin/env php

<?php

require_once __DIR__ . '/vendor/autoload.php';

use Swarrot\Processor\ProcessorInterface;
use Swarrot\Broker\MessageProvider\PeclPackageMessageProvider;
use Swarrot\Broker\MessageProvider\PhpAmqpLibMessageProvider;
use Swarrot\Broker\Message;
use Swarrot\Consumer;
use PhpAmqpLib\Connection\AMQPConnection;

class Processor implements ProcessorInterface
{
    public function process(Message $message, array $options)
    {
    }
}

if (!isset($argv[1])) {
    throw new \BadFunctionCallException('First argument must be the name of the provider to bench');
}

if ('extension' === $argv[1]) {
    $connection = new \AMQPConnection([
        'vhost' => 'bench'
    ]);
    $connection->connect();
    $channel = new \AMQPChannel($connection);
    $queue = new \AMQPQueue($channel);
    $queue->setName('bench');

    $messageProvider = new PeclPackageMessageProvider($queue);
} else {
    $connection = new AMQPConnection('127.0.0.1', 5672, 'guest', 'guest', 'bench');
    $messageProvider = new PhpAmqpLibMessageProvider($connection->channel(), 'bench');
}

$maxMessages = isset($argv[2])? (int) $argv[2] : 1000;

$stack = (new \Swarrot\Processor\Stack\Builder())
    ->push('Swarrot\Processor\MaxMessages\MaxMessagesProcessor')
    ->push('Swarrot\Processor\Ack\AckProcessor', $messageProvider)
;
$processor = $stack->resolve(new Processor());

$startTime = microtime(true);
$consumer = new Consumer($messageProvider, $processor);
$consumer->consume(['max_messages' => $maxMessages]);

$duration = round(microtime(true) - $startTime, 3);
$realMemoryPeak = round(memory_get_peak_usage(true)/1024/1024, 2);
$notRealMemoryPeak = round(memory_get_peak_usage()/1024/1024, 2);

echo "######################################\n";
echo "# Duration:            $duration seconds\n";
echo "# real MemoryPeak:     $realMemoryPeak MiB\n";
echo "# not real MemoryPeak: $notRealMemoryPeak MiB\n";
echo "######################################\n";
