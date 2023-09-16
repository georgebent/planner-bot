<?php

declare(strict_types=1);

namespace App\Tests\Reminder\Dto;

use App\Reminder\Dto\RemindDto;
use PHPUnit\Framework\TestCase;

class RemindDtoTest extends TestCase
{
    /**
     * @param $receiverName
     * @param $message
     * @param $receiveId
     * @param $jobId
     * @return void
     *
     * @dataProvider getData
     */
    public function testDto($receiverName, $message, $receiveId, $jobId)
    {
        $dto = new RemindDto($receiverName, $message, $receiveId, $jobId);

        $this->assertEquals($receiverName, $dto->getReceiverName());
        $this->assertEquals($message, $dto->getMessage());
        $this->assertEquals($receiveId, $dto->getReceiveId());
        $this->assertEquals($jobId, $dto->getJobId());
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [
            ['Test', 'Hello', '1asfdasf342gfsadgf', 2],
            ['Test 1', 'Hello 2', '3sdf4542gfsadgfs', 250],
        ];
    }

    /**
     * @param $receiverName
     * @param $message
     * @param $receiveId
     * @param $jobId
     * @return void
     *
     * @dataProvider getErrorData
     */
    public function testErrorDto($receiverName, $message, $receiveId, $jobId): void
    {
        $this->expectException(\TypeError::class);

        new RemindDto($receiverName, $message, $receiveId, $jobId);
    }

    /**
     * @return array
     */
    public function getErrorData(): array
    {
        return [
            [null, 'Hello', '1asfdasf342gfsadgf', 2],
            [1, 'Hello', '1asfdasf342gfsadgf', 2],
            [2.5, 'Hello', '1asfdasf342gfsadgf', 2],
            [[], 'Hello', '1asfdasf342gfsadgf', 2],
            [new \stdClass(), 'Hello', '1asfdasf342gfsadgf', 2],
            [fn() => true, 'Hello', '1asfdasf342gfsadgf', 2],
            ['Test 1', null, '3sdf4542gfsadgfs', 250],
            ['Test 1', 1, '3sdf4542gfsadgfs', 250],
            ['Test 1', 3.5, '3sdf4542gfsadgfs', 250],
            ['Test 1', [], '3sdf4542gfsadgfs', 250],
            ['Test 1', new \stdClass(), '3sdf4542gfsadgfs', 250],
            ['Test 1', fn() => true, '3sdf4542gfsadgfs', 250],
            ['Test 1', 'Hello 2', null, 250],
            ['Test 1', 'Hello 2', 2, 250],
            ['Test 1', 'Hello 2', 5.5, 250],
            ['Test 1', 'Hello 2', [], 250],
            ['Test 1', 'Hello 2', new \stdClass(), 250],
            ['Test 1', 'Hello 2', fn() => true, 250],
            ['Test 1', 'Hello 2', '3sdf4542gfsadgfs', null],
            ['Test 1', 'Hello 2', '3sdf4542gfsadgfs', 6.5],
            ['Test 1', 'Hello 2', '3sdf4542gfsadgfs', 'dsfdf'],
            ['Test 1', 'Hello 2', '3sdf4542gfsadgfs', []],
            ['Test 1', 'Hello 2', '3sdf4542gfsadgfs', new \stdClass()],
            ['Test 1', 'Hello 2', '3sdf4542gfsadgfs', fn() => true],
        ];
    }
}
