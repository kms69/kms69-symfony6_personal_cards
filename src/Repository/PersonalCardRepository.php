<?php
// src/Repository/PersonalCardRepository.php

namespace App\Repository;

use App\Entity\PersonalCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonalCard>
 *
 * @method PersonalCard|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalCard|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalCard[]    findAll()
 * @method PersonalCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalCardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalCard::class);
    }

    /**
     * Save a PersonalCard entity
     */
    public function save(PersonalCard $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Remove a PersonalCard entity
     */
    public function remove(PersonalCard $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Custom query example

    /**
     * @return PersonalCard[] Returns an array of PersonalCard objects
     */
    public function findByName(string $name): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name = :name')
            ->setParameter('name', $name)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Custom query example

    /**
     * @return PersonalCard[] Returns an array of PersonalCard objects
     */
    public function findByTel(string $tel): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.tel = :tel')
            ->setParameter('tel', $tel)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // Custom query example

    /**
     * @return PersonalCard[] Returns an array of PersonalCard objects
     */
    public function findByAddr(string $addr): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.addr = :addr')
            ->setParameter('addr', $addr)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
