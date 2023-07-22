<?php

namespace App\Repository;

use App\Entity\UserReceiver;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserReceiver>
 *
 * @method UserReceiver|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserReceiver|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserReceiver[]    findAll()
 * @method UserReceiver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserReceiverRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserReceiver::class);
    }
}
