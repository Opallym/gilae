<?php

// src/Repository/MessageRepository.php
namespace App\Repository;

use App\Entity\Message;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /** Récupère tous les messages non lus en premier */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.isRead', 'ASC')
            ->addOrderBy('m.receivedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}