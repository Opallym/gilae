<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * Trouve les réservations confirmées terminées sans e-mail d'avis envoyé.
     *
     * @param \DateTimeImmutable $now Date actuelle pour la comparaison
     * @return Reservation[]
     */
    public function findByFeedbackToSend(\DateTimeImmutable $now)
{
    return $this->createQueryBuilder('r')
        ->andWhere('r.dateFin < :now')
        ->andWhere('r.isConfirmed = true')
        ->andWhere('r.isFeedbackSent = false')
        ->setParameter('now', $now)
        ->getQuery()
        ->getResult();
}

}