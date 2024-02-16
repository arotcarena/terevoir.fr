<?php
namespace App\Controller;

use App\Persister\VisitPersister;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    public function __construct(
        private VisitPersister $visitPersister
    )
    {

    }

    #[Route('/rechercher', name: 'search', methods: 'GET')]
    public function index(): Response
    {
        $this->visitPersister->persist('search');
        
        return $this->render('search/index.html.twig');
    }
}