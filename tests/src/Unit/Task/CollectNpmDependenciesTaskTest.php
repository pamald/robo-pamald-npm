<?php

declare(strict_types = 1);

namespace Pamald\Robo\PamaldNpm\Tests\Unit\Task;

use Pamald\Robo\PamaldNpm\Task\CollectNpmDependenciesTask;
use Pamald\Robo\PamaldNpm\Task\TaskBase;
use Pamald\Robo\PamaldNpm\Tests\Helper\DummyTaskBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

/**
 * @phpstan-import-type RoboPamaldNpmCollectDependenciesTaskOptions from \Pamald\Robo\PamaldNpm\Phpstan
 */
#[CoversClass(CollectNpmDependenciesTask::class)]
#[CoversClass(TaskBase::class)]
class CollectNpmDependenciesTaskTest extends TaskTestBase
{
    /**
     * @return resource
     */
    protected static function createStream()
    {
        $filePath = 'php://memory';
        $resource = fopen($filePath, 'rw');
        if ($resource === false) {
            throw new \RuntimeException("file $filePath could not be opened");
        }

        return $resource;
    }

    /**
     * @return array<string, mixed>
     */
    public static function casesRunSuccess(): array
    {
        return [
            'basic' => [
                'expected' => [
                    'exitCode' => 0,
                    'exitMessage' => '',
                    'assets' => [
                        'pamald.npm.dependencies' => [
                            'a' => [],
                            'b' => [],
                        ],
                    ],
                ],
                'options' => [
                    'lock' => [
                        'packages' => [
                             'a' => [
                                 'version' => '1.0.0',
                             ],
                             'b' => [
                                 'version' => '2.0.0',
                             ],
                        ],
                    ],
                    'json' => [
                        'dependencies' => [
                            'a' => '^1.0',
                        ],
                        'devDependencies' => [
                            'b' => '^2.0',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @phpstan-param array<string, mixed> $expected
     * @phpstan-param RoboPamaldNpmCollectDependenciesTaskOptions $options
     */
    #[Test]
    #[DataProvider('casesRunSuccess')]
    public function testRunSuccess(array $expected, array $options): void
    {
        $taskBuilder = new DummyTaskBuilder();
        $taskBuilder->setContainer($this->getNewContainer());

        $task = $taskBuilder->taskPamaldCollectNpmPackages($options);
        $result = $task->run();

        static::assertSame($expected['exitCode'], $result->getExitCode());
        static::assertSame($expected['exitMessage'], $result->getMessage());
        static::assertSame(
            array_keys($expected['assets']['pamald.npm.dependencies']),
            array_keys($result['pamald.npm.dependencies']),
        );
    }
}
