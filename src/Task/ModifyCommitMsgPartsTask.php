<?php

declare(strict_types = 1);

namespace Pamald\Robo\PamaldNpm\Task;

use Pamald\Pamald\DependencyCollectorInterface;
use Pamald\PamaldNpm\DependencyCollector;
use Pamald\Robo\Pamald\Task\ModifyCommitMsgPartsTaskBase;

class ModifyCommitMsgPartsTask extends ModifyCommitMsgPartsTaskBase
{
    protected string $taskName = 'pamald - NPM - Modify commit message parts';

    protected string $packageManagerName = 'npm';

    /**
     * {@inheritdoc}
     */
    protected array $patterns = [
        // Standard name in the project root or in any sub-directory.
        'package-lock.json',
        '**/package-lock.json',
    ];

    protected function getJsonFilePath(string $lockFilePath): string
    {
        return preg_replace('@-lock\.json$@', '.json', $lockFilePath);
    }

    protected function getDependencyCollector(): DependencyCollectorInterface
    {
        return new DependencyCollector();
    }

    protected function isDomesticated(string $lockFilePath): bool
    {
        return str_starts_with(
            pathinfo($lockFilePath, \PATHINFO_BASENAME),
            'package-',
        );
    }
}
