<?php

declare(strict_types=1);

namespace App\Reminder\Storage;

use App\Entity\Job;
use Doctrine\ORM\EntityManagerInterface;

class ReminderStorage implements ReminderStorageInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }
    public function getRemindsForRun(\DateTimeImmutable $date): array
    {
        $date = $date->setTime((int) $date->format('H'), (int) $date->format('i'));

        return $this->entityManager->getRepository(Job::class)->findBy(['sendAt' => $date]);
    }
}
