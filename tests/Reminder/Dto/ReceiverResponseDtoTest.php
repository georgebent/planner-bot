<?php

declare(strict_types=1);

namespace App\Tests\Reminder\Dto;

use App\Reminder\Dto\ReceiverResponseDto;
use PHPUnit\Framework\TestCase;

class ReceiverResponseDtoTest extends TestCase
{
    /**
     * @param $message
     * @param $isSuccess
     * @return void
     *
     * @dataProvider getDtoData
     */
    public function testDto($message, $isSuccess): void
    {
        $dto = new ReceiverResponseDto($message, $isSuccess);

        $this->assertEquals($message, $dto->getMessage());
        $this->assertEquals($isSuccess, $dto->isSuccess());
    }

    public function getDtoData(): array
    {
        return [
            ['Message', true],
            ['Test data', true],
            ['Message', false],
            ['Test data', false],
        ];
    }

    /**
     * @param $message
     * @param $isSuccess
     * @return void
     *
     * @dataProvider getErrorData
     */
    public function testErrorDto($message, $isSuccess): void
    {
        $this->expectException(\TypeError::class);

        new ReceiverResponseDto($message, $isSuccess);
    }

    public function getErrorData(): array
    {
        return [
            ['Message', 'string'],
            ['Message', null],
            ['Message', 1],
            ['Message', 1.01],
            ['Message', []],
            ['Message', new \stdClass()],
            ['Message', fn() => true],
            [true, true],
            [false, true],
            [1, true],
            [1.01, true],
            [[], true],
            [new \stdClass(), true],
            [fn() => true, true],
        ];
    }
}
