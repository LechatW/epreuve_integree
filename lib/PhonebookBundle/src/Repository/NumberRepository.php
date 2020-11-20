<?php

namespace ZHC\PhonebookBundle\Repository;

use ZHC\PhonebookBundle\Entity\Number;
use ZHC\PhonebookBundle\Entity\Phonebook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Number|null find($id, $lockMode = null, $lockVersion = null)
 * @method Number|null findOneBy(array $criteria, array $orderBy = null)
 * @method Number[]    findAll()
 * @method Number[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NumberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Number::class);
    }

    public function findNotInPhonebook($idPhonebook)
    {

        $qb = $this->createQueryBuilder('n');

        $sub = $this->getEntityManager()->createQueryBuilder()
                    ->select('p')
                    ->from(Phonebook::class,'p')
                    ->where('n MEMBER OF p.numbers')
                    ->andWhere('p.id = :idPhonebook')
        ;

        $qb->andWhere($qb->expr()->not($qb->expr()->exists($sub->getDQL())))->setParameter('idPhonebook', $idPhonebook);

        $result = $qb->getQuery()
                     ->getResult()
        ;
        return $result;
    }

    public function findByPhonebook($idPhonebook)
    {
        return $this->createQueryBuilder('n')
                    ->innerJoin('n.phonebooks','p')
                    ->where('p.id = :idPhonebook')
                    ->setParameter('idPhonebook',$idPhonebook)
                    ->getQuery()
                    ->getResult()
        ;
    }

    public function findByUserAndType($idUser, $type)
    {
        return $this->createQueryBuilder('n')
                    ->where('n.user = :idUser')
                    ->andWhere('n.type = :type')
                    ->setParameters([
                        'idUser' => $idUser,
                        'type' => $type
                    ])
                    ->getQuery()
                    ->getSingleResult()
        ;
    }

}
