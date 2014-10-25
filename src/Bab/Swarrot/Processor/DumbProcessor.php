<?php

namespace Bab\Swarrot\Processor;

use Swarrot\Processor\ProcessorInterface;
use Swarrot\Broker\Message;

class DumbProcessor implements ProcessorInterface
{
    public function process(Message $message, array $options)
    {
    }
}
