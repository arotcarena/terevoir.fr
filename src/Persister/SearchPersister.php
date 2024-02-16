<?php
namespace App\Persister;

use DateTimeZone;
use App\Entity\Search;
use DateTimeImmutable;
use App\Entity\Searcher;
use App\Repository\SearchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SearchPersister 
{

    public function __construct(
        private EntityManagerInterface $em,
        private ValidatorInterface $validator,
        private SearchRepository $searchRepository
    )
    {

    }

    /**
     *
     * @param Object $searchData
     * 
     * /**
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
     * @return array [bool $success, Search $search, array $violations]
     */
    public function persist(Object $searchData): array
    {
        $search = (new Search)
        ->setFirstName($searchData->searchFirstName)
        ->setLastName($searchData->searchLastName)
        ->setAge($searchData->searchAge)
        ->setCityFirstTime($searchData->searchCityFirst->value)
        ->setCityLastTime($searchData->searchCityLast->value)
        ->setSearcher(
            (new Searcher)
                ->setFirstName($searchData->myFirstName)
                ->setLastName($searchData->myLastName)
                ->setBirthYear($searchData->myBirthYear)
                ->setEmail($searchData->myEmail)
                ->setPhone($searchData->myPhone)
                ->setConsent($searchData->myConsent)
                ->setCreatedAt(new DateTimeImmutable("now", new DateTimeZone("Europe/Paris")))
        )
        ->setCreatedAt(new DateTimeImmutable("now", new DateTimeZone("Europe/Paris")))
        ;

        $searchViolations = $this->validator->validate($search);
        $searcherViolations = $this->validator->validate($search->getSearcher());
        $violations = array_merge(iterator_to_array($searchViolations), iterator_to_array($searcherViolations));
        if(count($violations) === 0)
        {
            if($this->searchRepository->sameSearchExists($search))
            {
                $violation = new ConstraintViolation(
                    'Vous avez déjà effectué cette recherche, il n\'est pas nécessaire de recommencer. Dès que '.$searchData->searchFirstName.' vous recherchera à son tour nous vous en informerons', 
                    null,
                    [],
                    $search,
                    'main',
                    null
                );
                return [false, $search, [$violation]];
            }
            $this->em->persist($search);
            $this->em->flush();
            return [true, $search, $violations];
        }
        return [false, $search, $violations];
    }

    


    public function remove(Search $search):void
    {
        $searcher = $search->getSearcher();
        // pour éviter CANNOT UPDATE OR DELETE A CHILD ROW, FOREIGN KEY CONSTRAINTS FAILS on se charge manuellement de supprimer le searcher uniquement s'il n'a pas d'autre search
        if(count($searcher->getSearches()) <= 1)
        {
            $this->em->remove($searcher);
        }
        $this->em->remove($search);
        $this->em->flush();
    }

    /**
     * Undocumented function
     *
     * @param Search $search
     * @param string $message
     * @return ConstraintViolationList
     */
    public function persistMessage(Search $search, string $message)
    {
        $search->setMessage($message);
        $violations = $this->validator->validate($search);
        if(count($violations) === 0)
        {
            $this->em->flush();
        }
        return $violations;
    }
}