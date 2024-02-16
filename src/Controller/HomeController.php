<?php
namespace App\Controller;

use App\Persister\VisitPersister;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        private VisitPersister $visitPersister
    )
    {

    }

    #[Route('/', name: 'home', methods: 'GET')]
    public function index(): Response
    {
        $this->visitPersister->persist('home');
        
        return $this->render('home/index.html.twig');
    }
}