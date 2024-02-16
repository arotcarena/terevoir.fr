<?php 
namespace App\Controller;

use Exception;
use App\Entity\Search;
use App\Services\Algo;
use App\Email\MatchEmailSender;
use App\Persister\SearchPersister;
use App\Repository\SearchRepository;
use App\Services\ViolationsConvertor;
use Doctrine\ORM\EntityManagerInterface;
use App\Email\SearchPersistedEmailSender;
use App\Email\SearcherSideMatchEmailSender;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
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
     * 
    */

class ApiController extends AbstractController 
{
    public function __construct(
        private Algo $algo,
        private EntityManagerInterface $em,
        private MatchEmailSender $matchEmailSender,
        private SearcherSideMatchEmailSender $searcherSideMatchEmailSender,
        private SearchPersistedEmailSender $searchPersistedEmailSender,
        private SearchPersister $searchPersister,
        private SearchRepository $searchRepository,
        private ViolationsConvertor $violationsConvertor 
    )
    {

    }

    private function getMatchingData(Search $search):array
    {
        $searcher = $search->getSearcher();
        return [
            'firstName' => $searcher->getFirstName(),
            'email' => $searcher->getEmail(),
            'phone' => $searcher->getPhone(),
            'message' => $search->getMessage() 
        ];
    }

    #[Route('/api/research', name: 'api_research', methods: ['POST'])]
    public function research(Request $request): Response
    {
        $searchData = json_decode($request->getContent());
        $matchingSearch = $this->algo->findMatchingSearch($searchData);

        // s'il y a match, on renvoie les données de la search qui a matché, et on la supprime
        if($matchingSearch) 
        {
            $this->matchEmailSender->send($matchingSearch->getSearcher(), $searchData);
            $this->searcherSideMatchEmailSender->send($matchingSearch, $searchData);
            
            $matchingData = $this->getMatchingData($matchingSearch);
            $this->searchPersister->remove($matchingSearch);   // supprime aussi le searcher s'il n'a pas d'autre search
            return new Response(json_encode([
                'matchingData' => $matchingData
            ]), 200);
        }

        // s'il n'y a pas match, on sauvegarde la search et on renvoie l'id
        [$success, $search, $violations] = $this->searchPersister->persist($searchData);
        if(!$success)
        {
            return new Response(json_encode([
                'errors' => $this->violationsConvertor->convertToSearchData($violations)
            ]), 500);
        }
        $this->searchPersistedEmailSender->send($search);
        return new Response(json_encode([
            'search' => [
                'id' => $search->getId(),
                'firstName' => $search->getFirstName()
            ]
        ]), 200);
    }


    #[Route('/api/persistMessage/{id}', name: 'api_persistMessage', methods: 'POST')]
    public function persistMessage(int $id, Request $request): Response
    {
        $message = json_decode($request->getContent());

        // si pas de message, on ne fait rien
        if($message === '')
        {
            return new Response(json_encode('ok'), 200);
        }

        //sinon on tente de sauvegarder le message
        $search = $this->searchRepository->find($id);
        if($search === null)
        {
            throw new Exception('Aucune Search existante avec l\'id "'.$id.'", il est donc impossible de sauvegarder le message dans cette search');
        }
        $violations = $this->searchPersister->persistMessage($search, $message);
        if(count($violations) === 0)
        {
            return new Response(json_encode('ok'), 200);
        }
        return new Response(json_encode(['errors' => $this->violationsConvertor->convertToSearchData($violations)]), 500);
    }
}