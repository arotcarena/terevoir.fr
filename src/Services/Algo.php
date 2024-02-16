<?php
namespace App\Services;

use App\Entity\Search;
use App\Repository\SearchRepository;
use App\Repository\SearcherRepository;

class Algo 
{
    public function __construct(
        private SearchRepository $searchRepository
    )
    {

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
    public function findMatchingSearch(Object $searchData): ?Search
    {
        $searchesThatCanMatch = $this->searchRepository->findAllCanMatch($searchData);
        $searchesWithTenPoints = [];
        foreach($searchesThatCanMatch as $search)
        {
            /** @var Search */
            $search = $search;

            $points = 0;

            if($searchData->searchLastName !== null)
            {
                soundex($search->getSearcher()->getLastName()) === soundex($searchData->searchLastName) && $points += 5;
            }

            soundex($search->getLastName()) === soundex($searchData->myLastName) && $points += 5;

            $searchCityFirst = $searchData->searchCityFirst ? $searchData->searchCityFirst->value : 'no-city';
            $searchCityLast = $searchData->searchCityLast ? $searchData->searchCityLast->value : 'no-city';

            if($search->getCityFirstTime() === $searchCityFirst && $search->getCityLastTime() === $searchCityLast)
            {
                $search->getCityFirstTime() !== $search->getCityLastTime() ? $points += 10 : $points += 8;
            }
            elseif($search->getCityFirstTime() === $searchCityFirst || $search->getCityLastTime() === $searchCityLast)
            {
                $points += 6;
            }
            
            if($this->calcDiff($search->getAge(), ((int)date('Y') - $searchData->myBirthYear)) <= 5)
            {
                $points += 2;
            }
            elseif($this->calcDiff($search->getAge(), ((int)date('Y') - $searchData->myBirthYear)) <= 10)
            {
                $points += 1;
            }

            if($this->calcDiff($searchData->searchAge, ((int)date('Y') - $search->getAge())) <= 5)
            {
                $points += 2;
            }
            elseif($this->calcDiff($searchData->searchAge, ((int)date('Y') - $search->getAge())) <= 10)
            {
                $points += 1;
            }

            if($points >= 10)
            {
                $searchesWithTenPoints[] = [
                    'search' => $search,
                    'points' => $points
                ];
            }
        }

        // s'il une seule search a matché on la retourne, sinon on retourne celle qui a le plus de pts, ou l'une de celles qui a le plus de points
        if(count($searchesWithTenPoints) === 1)
        {
            return $searchesWithTenPoints[0]['search'];
        }
        else
        {
            $searchWithMaxPoints = null;
            $maxPoints = 0;
            foreach($searchesWithTenPoints as $search)
            {
                if($search['points'] >= $maxPoints)
                {
                    $maxPoints = $search['points'];
                    $searchWithMaxPoints = $search['search'];
                }
            }
            return $searchWithMaxPoints;
        }
        return null;
    }


    private function calcDiff(int $a, int $b)
    {
        if($a === $b)
        {
            return 0;
        }
        if($a > $b)
        {
            return $a - $b;
        }
        return $b - $a;
    }

    /**
     * de base il faut que les prénoms correspondent 
     * 
     * ensuite
     * 
     * si les noms correspondent, 5 pts --->  x 2  = 10pts
     * 
     * si les deux villes correspondent et sont différentes, 10 pts
     * si les deux villes correspondent et sont identiques, 8pts
     * 
     * si l'une des villes seulement correspond, 6 pts
     * 
     * si les ages correspondent à 5 ans près, 2 pts ---> x 2 = 4 pts
     * si les ages correspondent à 10 ans près, 1 pt  ---> x 2 = 2 pts
     * 
     * si on a 10 pts la search est retenue, ensuite on renvoie la search avec le plus de points
     * */
}