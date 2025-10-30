<?php

declare(strict_types=1);

namespace Crell\PageTree;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class ConsoleLogger implements LoggerInterface
{
    use LoggerTrait;

    /**
     * @inheritDoc
     */
    public function log($level, \Stringable|string $message, array $context = []): void
    {
        printf("%s: %s (%s)\n", strtoupper($level), $message, json_encode($context));
    }
}
