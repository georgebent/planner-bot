<?php

declare(strict_types=1);

namespace App\Tests\Reminder\Sender;

use App\Entity\Job;
use App\Reminder\Dto\RemindDto;
use App\Reminder\Sender\RemindSaver;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class RemindSaverTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testProcess()
    {
        $remindDto =  new RemindDto('receiver', 'message', 'receive', 1);

        $job = new Job();
        $job->setSentTimes(1);
        $job->setSendAt(new \DateTimeImmutable());

        $repository = $this->createMock(JobRepository::class);
        $repository->method('find')->willReturn($job);

        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturn($repository);

        $logger = $this->createMock(LoggerInterface::class);

        $saver = new RemindSaver($em, $logger);
        $class = new \ReflectionClass($saver);
        $method = $class->getMethod('process');

        $result = $method->invokeArgs($saver, [$remindDto]);

        $this->assertTrue($result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testProcessFalse()
    {
        $remindDto =  new RemindDto('receiver', 'message', 'receive', 1);
        $repository = $this->createMock(JobRepository::class);
        $repository->method('find')->willReturn(null);

        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturn($repository);

        $logger = $this->createMock(LoggerInterface::class);

        $saver = new RemindSaver($em, $logger);
        $class = new \ReflectionClass($saver);
        $method = $class->getMethod('process');

        $result = $method->invokeArgs($saver, [$remindDto]);

        $this->assertFalse($result);
    }
}
