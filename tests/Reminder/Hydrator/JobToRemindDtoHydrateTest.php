<?php

declare(strict_types=1);

namespace App\Tests\Reminder\Hydrator;

use App\Entity\Job;
use App\Entity\Receiver;
use App\Entity\UserReceiver;
use App\Reminder\Hydrator\JobToRemindDtoHydrate;
use PHPUnit\Framework\TestCase;

class JobToRemindDtoHydrateTest extends TestCase
{
    /**
     * @param Job $job
     * @return void
     *
     * @dataProvider getData
     */
    public function testHydrator(Job $job)
    {
        $dto = JobToRemindDtoHydrate::hydrate($job);

        $this->assertEquals($job->getId(), $dto->getJobId());
        $this->assertEquals($job->getMessage(), $dto->getMessage());
        $this->assertEquals($job->getUserReceiver()?->getToken(), $dto->getReceiveId());
        $this->assertEquals($job->getUserReceiver()?->getReceiver()?->getName(), $dto->getReceiverName());
    }

    public function getData(): array
    {
        $data = [
            ['name', 'adfs324345asdf32455', 1, 'Hello'],
            ['User name', '3radfs324345asdf32455', 2, 'Hello there'],
        ];

        $result = [];

        foreach ($data as $jobData) {
            $receiver = new Receiver();
            $receiver->setName($jobData[0]);

            $userReceiver = new UserReceiver();
            $userReceiver->setToken($jobData[1]);
            $userReceiver->setReceiver($receiver);

            $job = $this->createMock(Job::class);
            $job->method('getId')->willReturn($jobData[2]);
            $job->method('getMessage')->willReturn($jobData[3]);
            $job->method('getUserReceiver')->willReturn($userReceiver);


            $result[] = [$job];
        }

        return $result;
    }
}
