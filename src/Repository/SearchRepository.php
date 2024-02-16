<?php

namespace App\Repository;

use PDO;
use App\Entity\Search;
use Doctrine\ORM\Query\Parameter;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PhpParser\Builder\Param;

/**
 * @extends ServiceEntityRepository<Search>
 *
 * @method Search|null find($id, $lockMode = null, $lockVersion = null)
 * @method Search|null findOneBy(array $criteria, array $orderBy = null)
 * @method Search[]    findAll()
 * @method Search[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Search::class);
    }

    public function save(Search $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Search $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * @param Object $searchData
     * 
     * SearchData {
     *    searchFirstName = '';
     *    searchLastName = '';
     *    searchAge = '';
     *    searchCityFirst = {
     *        value: '',
     *        suggested: false
     *    };
     *    searchCityLast = {
     *        value: '',
     *        suggested: false
     *    };
     *    myFirstName = '';
     *    myLastName = '';
     *    myBirthYear = '';
     *    myEmail = '';
     *    myPhone = '';
     *    myConsent = false;
     *}
     * @return Search|null
    */
    public function findAllCanMatch(Object $searchData): array 
    {
        //pour l'instant on vérifie seulement que les prénoms entrés des deux côtés ont le même SOUNDEX
        return $this->createQueryBuilder('s')
                    ->select('s', 'searcher')
                    ->join('s.searcher', 'searcher')
                    ->where('SOUNDEX(searcher.firstName) LIKE SOUNDEX(:searchFirstName) AND SOUNDEX(s.firstName) LIKE SOUNDEX(:myFirstName)')
                    ->setParameter('searchFirstName', '%'.$searchData->searchFirstName.'%')
                    ->setParameter('myFirstName', '%'.$searchData->myFirstName.'%')                 
                    ->getQuery()
                    ->getResult()
                    ;
    }

    public function sameSearchExists(Search $search): bool 
    {
        $searcher = $search->getSearcher();
        $sameSearch = $this->createQueryBuilder('s')
                            ->select('s.id')
                            ->join('s.searcher', 'searcher')
                            ->where('SOUNDEX(searcher.firstName) LIKE SOUNDEX(:searcher_firstName)')
                            ->andWhere('SOUNDEX(searcher.lastName) LIKE SOUNDEX(:searcher_lastName)')
                            ->andWhere('SOUNDEX(s.firstName) LIKE SOUNDEX(:firstName)')
                            ->andWhere('SOUNDEX(s.lastName) LIKE SOUNDEX(:lastName)')
                            ->andWhere('s.cityFirstTime = :cityFirstTime')
                            ->andWhere('s.cityLastTime = :cityLastTime')
                            ->andWhere('s.age = :age')
                            ->andWhere('searcher.birthYear = :searcher_birthYear')
                            ->andWhere('searcher.email = :searcher_email')
                            ->setParameters(new ArrayCollection([
                                    new Parameter('searcher_firstName', $searcher->getFirstName()),
                                    new Parameter('searcher_lastName', $searcher->getLastName()),
                                    new Parameter('firstName', $search->getFirstName()),
                                    new Parameter('lastName', $search->getLastName()),
                                    new Parameter('cityFirstTime', $search->getCityFirstTime()),
                                    new Parameter('cityLastTime', $search->getCityLastTime()),
                                    new Parameter('age', $search->getAge()),
                                    new Parameter('searcher_birthYear', $searcher->getBirthYear()),
                                    new Parameter('searcher_email', $searcher->getEmail())
                            ]))
                            ->getQuery()
                            ->getOneOrNullResult()
                            ;
        return $sameSearch !== null;
    }

//    /**
//     * @return Search[] Returns an array of Search objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Search
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
