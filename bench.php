#!/usr/bin/env php

<?php

if (!isset($argv[1])) {
    throw new \BadFunctionCallException('First argument must be the name of the provider to bench');
}

$file = $argv[1];

$startTime = microtime(true);

require __DIR__.'/bench/'.$file.'.php';

$duration = round(microtime(true) - $startTime, 3);
$realMemoryPeak = round(memory_get_peak_usage(true)/1024/1024, 2);
$notRealMemoryPeak = round(memory_get_peak_usage()/1024/1024, 2);

echo "######################################\n";
echo "# Duration:            $duration seconds\n";
echo "# real MemoryPeak:     $realMemoryPeak MiB\n";
echo "# not real MemoryPeak: $notRealMemoryPeak MiB\n";
echo "######################################\n";
