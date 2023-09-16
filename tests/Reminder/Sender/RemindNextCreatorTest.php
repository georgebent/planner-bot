<?php

declare(strict_types=1);

namespace App\Tests\Reminder\Sender;

use App\Entity\Interval;
use App\Entity\Job;
use App\Reminder\Dto\RemindDto;
use App\Reminder\Sender\RemindNextCreator;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class RemindNextCreatorTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testProcess()
    {
        $remindDto =  new RemindDto('receiver', 'message', 'receive', 1);

        $interval = new Interval();
        $interval->setPattern('+1 month');
        $date = new \DateTimeImmutable();
        $dateNextMonth = $date->modify('+ 1 month');

        $job = new Job();
        $job->setSentTimes(1);
        $job->setMaxTimes(10);
        $job->setInterval($interval);
        $job->setSendAt($date);

        $repository = $this->createMock(JobRepository::class);
        $repository->method('find')->willReturn($job);

        $em = $this->createMock(EntityManagerInterface::class);
        $em->method('getRepository')->willReturn($repository);
        $em->method('persist')->will($this->returnCallback(function(Job $job) use ($dateNextMonth) {
            $this->assertEquals($dateNextMonth, $job->getSendAt());
        }));

        $logger = $this->createMock(LoggerInterface::class);

        $creator = new RemindNextCreator($em, $logger);
        $class = new \ReflectionClass($creator);
        $method = $class->getMethod('process');

        $result = $method->invokeArgs($creator, [$remindDto]);

        $this->assertTrue($result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testProcessCancel()
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

        $creator = new RemindNextCreator($em, $logger);
        $class = new \ReflectionClass($creator);
        $method = $class->getMethod('process');

        $result = $method->invokeArgs($creator, [$remindDto]);

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

        $creator = new RemindNextCreator($em, $logger);
        $class = new \ReflectionClass($creator);
        $method = $class->getMethod('process');

        $result = $method->invokeArgs($creator, [$remindDto]);

        $this->assertFalse($result);
    }
}
