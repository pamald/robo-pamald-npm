<?php

declare(strict_types = 1);

namespace Pamald\Robo\PamaldNpm;

use League\Container\ContainerAwareInterface;
use Robo\Collection\CollectionBuilder;

/**
 * @phpstan-import-type RoboPamaldNpmCollectDependenciesTaskOptions from \Pamald\Robo\PamaldNpm\Phpstan
 * @phpstan-import-type RoboPamaldNpmModifyCommitMsgPartsTaskOptions from \Pamald\Robo\PamaldNpm\Phpstan
 */
trait PamaldNpmTaskLoader
{
    /**
     * @phpstan-param RoboPamaldNpmCollectDependenciesTaskOptions $options
     *
     * @return \Pamald\Robo\PamaldNpm\Task\CollectNpmDependenciesTask|\Robo\Collection\CollectionBuilder
     */
    protected function taskPamaldCollectNpmPackages(array $options = []): CollectionBuilder
    {
        /** @var \Pamald\Robo\PamaldNpm\Task\CollectNpmDependenciesTask|\Robo\Collection\CollectionBuilder $task */
        $task = $this->task(Task\CollectNpmDependenciesTask::class);
        $task->setOptions($options);

        return $task;
    }

    /**
     * @phpstan-param RoboPamaldNpmModifyCommitMsgPartsTaskOptions $options
     *
     * @return \Pamald\Robo\PamaldNpm\Task\ModifyCommitMsgPartsTask|\Robo\Collection\CollectionBuilder
     */
    protected function taskPamaldNpmModifyCommitMsgParts(array $options = []): CollectionBuilder
    {
        /** @var \Pamald\Robo\PamaldNpm\Task\ModifyCommitMsgPartsTask|\Robo\Collection\CollectionBuilder $task */
        $task = $this->task(Task\ModifyCommitMsgPartsTask::class);
        if ($this instanceof ContainerAwareInterface) {
            $task->setContainer($this->getContainer());
        }

        $task->setOptions($options);

        return $task;
    }
}
