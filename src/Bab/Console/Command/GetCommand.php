<?php

namespace Bab\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Swarrot\Broker\MessageProvider\PeclPackageMessageProvider;
use Swarrot\Broker\MessageProvider\PhpAmqpLibMessageProvider;
use Swarrot\Consumer;
use PhpAmqpLib\Connection\AMQPConnection;
use Bab\Swarrot\Processor\DumbProcessor;

class GetCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('get')
            ->setDescription('Try to get & ack some messages')
            ->addArgument('provider', InputArgument::REQUIRED, 'Provider to test [ext|lib]')
            ->addOption('messages', 'm', InputOption::VALUE_OPTIONAL, 'How many messages to get ?', 1000)
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function doExecute(InputInterface $input, OutputInterface $output)
    {
        $provider = $input->getArgument('provider');

        if ('ext' === $provider) {
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

        $stack = (new \Swarrot\Processor\Stack\Builder())
            ->push('Swarrot\Processor\MaxMessages\MaxMessagesProcessor')
            ->push('Swarrot\Processor\Ack\AckProcessor', $messageProvider)
        ;
        $processor = $stack->resolve(new DumbProcessor());

        $consumer = new Consumer($messageProvider, $processor);
        $consumer->consume(['max_messages' => (int) $input->getOption('messages')]);
    }
}
