<?php

declare(strict_types=1);

namespace App\Tests\Reminder\Sender;

use App\Reminder\Dto\ReceiverResponseDto;
use App\Reminder\Dto\RemindDto;
use App\Reminder\Receivers\ReceiverInterface;
use App\Reminder\Sender\RemindSender;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class RemindSenderTest extends TestCase
{
    /**
     * @throws \ReflectionException
     *
     * @dataProvider getData
     */
    public function testProcess($isSent)
    {
        $logger = $this->createMock(LoggerInterface::class);
        $receiver = $this->createMock(ReceiverInterface::class);
        $receiver->method('send')->willReturn(new ReceiverResponseDto('', $isSent));

        $remindDto =  new RemindDto('receiver', 'message', 'receive', 1);

        $sender = new RemindSender($receiver, $logger);
        $class = new \ReflectionClass($sender);
        $method = $class->getMethod('process');

        $result = $method->invokeArgs($sender, [$remindDto]);

        $this->assertEquals($isSent, $result);
    }

    public function getData(): array
    {
        return [
            [
                true,
            ], [
                false,
            ]
        ];
    }
}
