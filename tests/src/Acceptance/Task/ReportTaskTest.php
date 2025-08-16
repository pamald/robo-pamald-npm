<?php

declare(strict_types = 1);

namespace Pamald\Robo\PamaldNpm\Tests\Acceptance\Task;

class ReportTaskTest extends TaskTestBase
{
    public function testRoboTaskPamaldReport(): void
    {
        $actual = $this->runRoboCommand(['pamald:report']);
        $expected = [
            'exitCode' => 0,
            // phpcs:disable Generic.Files.LineLength.TooLong
            'out' => <<< 'Text'
                +---------------+-----------+-----------+---------+---------+----------+----------+------------+------------+---------+---------+
                | Name          | L Version | R Version | L Type  | R Type  | L Link   | R Link   | L Env      | R Env      | L Depth | R Depth |
                +---------------+-----------+-----------+---------+---------+----------+----------+------------+------------+---------+---------+
                | Production - Direct                                                                                                           |
                | find-versions | 5.0.0     | 5.1.0     | package | package | required | required | production | production | direct  | direct  |
                | Other                                                                                                                         |
                | semver-regex  | 4.0.5     | 4.2.0     | package | package |          |          |            |            | child   | child   |
                +---------------+-----------+-----------+---------+---------+----------+----------+------------+------------+---------+---------+

                Text,
            // phpcs:enable Generic.Files.LineLength.TooLong
            'err' => implode(
                "\n",
                [
                    ' [pamald - Collect NPM dependencies] Collect NPM dependencies',
                    ' [pamald - Collect NPM dependencies] Collect NPM dependencies',
                    ' [Pamald\Robo\Pamald\Task\LockDifferTask] ',
                    ' [Pamald\Robo\Pamald\Task\ReporterTask] ',
                    '',
                ],
            ),
        ];

        static::assertSame($expected['out'], $actual['out'], 'stdOutput');
        static::assertSame($expected['err'], $actual['err'], 'stdError');
        static::assertSame($expected['exitCode'], $actual['exitCode'], 'exitCode');
    }
}
