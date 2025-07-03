<?php

namespace App\Repository;

use App\Entity\Conseils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conseil>
 */
class ConseilsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conseils::class);
    }

    // Ici pas besoin de méthode personnalisée : `findBy` suffit !
}
