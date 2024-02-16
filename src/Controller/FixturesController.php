<?php

namespace App\Controller;

use App\Services\Algo;
use App\Form\TestSearchData;
use App\Form\TestSearchFormType;
use App\Repository\SearchRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FixturesController extends AbstractController
{
    #[Route('/fixtures', name: 'fixtures_index')]
    public function index(SearchRepository $searchRepository, Request $request, Algo $algo): Response
    {
        $testSearchData = new TestSearchData;
        $form = $this->createForm(TestSearchFormType::class, $testSearchData);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $searchMatching = $algo->findMatchingSearch($testSearchData);
            $searches = [];
        }
        else
        {
            $searches = $searchRepository->findAll();
            $searchMatching = null;
        }
        return $this->render('fixtures/index.html.twig', [
            'searches' => $searches,
            'searchMatching' => $searchMatching,
            'form' => $form->createView()
        ]);
    }
    
}
