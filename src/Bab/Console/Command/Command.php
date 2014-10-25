<?php

namespace Bab\Console\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;

abstract class Command extends BaseCommand
{
    /**
     * doExecute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    abstract protected function doExecute(InputInterface $input, OutputInterface $output);

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);

        $this->doExecute($input, $output);

        $duration = microtime(true) - $startTime;
        $memoryPeak = memory_get_peak_usage(true);

        $formatter = $this->getHelper('formatter');

        $table = new Table($output);
        $table
            ->setRows(array(
                array('Duration', $formatter->formatTime($duration)),
                new TableSeparator(),
                array('Memory peak', $formatter->formatMemory($memoryPeak)),
            ))
        ;
        $table->render();
    }
}
