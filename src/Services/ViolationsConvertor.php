<?php
namespace App\Services;

use App\Entity\Search;
use App\Entity\Searcher;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;



const SEARCH_TO_SEARCH_DATA_CORRESPONDANCE = [
    'firstName' => 'searchFirstName',
    'lastName' => 'searchLastName',
    'age' => 'searchAge',
    'cityFirstTime' => 'searchCityFirst',
    'cityLastTime' => 'searchCityLast',
    'message' => 'message'
];

const SEARCHER_TO_SEARCH_DATA_CORRESPONDANCE = [
    'firstName' => 'myFirstName',
    'lastName' => 'myLastName',
    'birthYear' => 'myBirthYear',
    'email' => 'myEmail',
    'phone' => 'myPhone',
    'consent' => 'myConsent'
];

class ViolationsConvertor
{
    public function convertToSearchData(ConstraintViolationList|array $violations): array
    {
        $errors = [];
        foreach($violations as $violation)
        {
            /** @var ConstraintViolation */
            $violation = $violation;
            if($violation->getPropertyPath() === 'main')
            {
                $errors['main'][] = $violation->getMessage();
            }
            elseif($violation->getRoot() instanceof Search) 
            {
                $errors[SEARCH_TO_SEARCH_DATA_CORRESPONDANCE[$violation->getPropertyPath()]][] = $violation->getMessage();
            }
            elseif($violation->getRoot() instanceof Searcher)
            {
                $errors[SEARCHER_TO_SEARCH_DATA_CORRESPONDANCE[$violation->getPropertyPath()]][] = $violation->getMessage();
            }
        }
        return $errors;
    }
}
