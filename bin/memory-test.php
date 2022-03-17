<?php

require_once __DIR__ . '/../vendor/autoload.php';

use MaddHatter\MarkdownTable\Builder;
use Symfony\Component\Process\Process;

function addTableRow(Builder $tableBuilder, string $type, array $output)
{
    $tableBuilder->row([$type, $output['class_sizeof'], $output['sizeof'], $output['memory_get_usage']]);
}

foreach ([0, 100, 1000, 10000] as $count) {
    $tableBuilder = new Builder();
    $tableBuilder->headers(['type', 'var_class_sizeof(bytes)', 'var_sizeof(bytes)', 'memory_get_usage(bytes)']);
    echo '#### Items in collection: ' . $count . PHP_EOL;
    foreach (['array', 'annotation', 'monomorphic', 'type-erased'] as $item) {
        if (in_array($item, ['monomorphic', 'type-erased'])) {
            $process = Process::fromShellCommandline(sprintf('composer dump-generics --type=%s', $item));
            $process->mustRun();
        }

        $process = Process::fromShellCommandline(sprintf('php bin/memory-test-%s.php %d', $item, $count));
        $process->mustRun();
        addTableRow($tableBuilder, sprintf('%s(count: %d)', $item, $count), json_decode($process->getOutput(), true));
    }

    echo $tableBuilder->render() . PHP_EOL;
}


