<?php

namespace Tapcore\Integration\Entity;

use PHPUnit\Framework\TestCase;

class BuildTest extends TestCase
{
    public function testCreatingFromArray()
    {
        $source = [
            'id' => 123,
            'status' => Build::STATUS_IN_PROGRESS,
            'error_code' => Build::ERROR_INVALID_APK,
            'created_at' => '2017-02-03 12:23:34',
            'updated_at' => '2017-03-04 13:43:54',
        ];

        $build = Build::createFromResponseData($source);

        $this->assertSame($source['id'], $build->getId());
        $this->assertSame($source['status'], $build->getStatus());
        $this->assertSame($source['error_code'], $build->getErrorCode());
        $this->assertEquals(new \DateTime($source['created_at']), $build->getCreatedAt());
        $this->assertEquals(new \DateTime($source['updated_at']), $build->getUpdatedAt());
    }

    public function finishedStatusProvider()
    {
        return [
            'new'         => [ Build::STATUS_NEW, false, false ],
            'in queue'    => [ Build::STATUS_IN_QUEUE, false, false ],
            'in progress' => [ Build::STATUS_IN_PROGRESS, false, false ],
            'aborted'     => [ Build::STATUS_ABORTED, true, false ],
            'failure'     => [ Build::STATUS_FAILURE, true, false ],
            'success'     => [ Build::STATUS_SUCCESS, true, true ],
        ];
    }

    /**
     * @dataProvider finishedStatusProvider
     *
     * @param int $status
     * @param bool $isFinished
     * @param bool $isSuccess
     */
    public function testFinishedStatus($status, $isFinished, $isSuccess)
    {
        $build = Build::createFromResponseData([
            'status' => $status,
        ]);

        $this->assertSame($isFinished, $build->isFinished());
        $this->assertSame($isSuccess, $build->isSuccess());
    }
}
