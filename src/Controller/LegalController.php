<?php
namespace App\Controller;

use App\Persister\VisitPersister;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LegalController extends AbstractController
{
    public function __construct(
        private VisitPersister $visitPersister
    )
    {

    }

    
    #[Route('/mentions-légales', name: 'legal_legal', methods: 'GET')]
    public function legal(): Response
    {
        $this->visitPersister->persist('legal');
        
        return $this->render('legal/legal.html.twig');
    }
    #[Route('/conditions-générales-d-utilisation', name: 'legal_cgu', methods: 'GET')]
    public function cgu(): Response
    {
        $this->visitPersister->persist('cgu');
        
        return $this->render('legal/cgu.html.twig');
    }
}