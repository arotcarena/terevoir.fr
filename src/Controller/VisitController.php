<?php
namespace App\Controller;

use App\Repository\VisitRepository;
use App\Repository\VisitorRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VisitController extends AbstractController
{
    public function __construct(
        private VisitRepository $visitRepository,
        private VisitorRepository $visitorRepository
    )
    {

    }

    #[Route('/visit')]
    public function index(): Response
    {
        $visits = $this->visitRepository->myFindAll();
        $uniqVisitsCount = $this->visitRepository->countUniqVisits();
        $visitsCount = $this->visitRepository->count([]);
        $visitorsCount = $this->visitorRepository->count([]);
        $uniqVisitorsCount = $this->visitorRepository->countUniqVisitors();
        $visitors = $this->visitorRepository->myFindAll();

        return $this->render('visit/index.html.twig', [
            'visits' => $visits,
            'visitors' => $visitors,
            'uniq_visits_count' => $uniqVisitsCount,
            'uniq_visitors_count' => $uniqVisitorsCount,
            'visits_count' => $visitsCount,
            'visitors_count' => $visitorsCount
        ]);
    }
}