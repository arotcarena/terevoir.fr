<?php 
namespace App\Controller;

use App\Entity\Visitor;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ApiVisitController extends AbstractController
{

    public function __construct(
        private TokenGeneratorInterface $tokenGenerator,
        private VisitorRepository $visitorRepository,
        private EntityManagerInterface $em
    )
    {

    }

    #[Route('/api/visit/cookieConsent', name: 'api_visit_cookieConsent', methods: ['GET'])]
    public function cookieConsent(Request $request): Response
    {
        $session = $request->getSession();
        $token = $session->get('visitor');
        if($token)
        {
            /** @var Visitor */
            $visitor = $this->visitorRepository->findOneByToken($token);
            $visitor->setTracked(true);
        }
        else
        {
            $token = $this->tokenGenerator->generateToken();
            $session->set('visitor', $token);
            $visitor = (new Visitor)->setToken($token)->setTracked(true);
            $this->em->persist($visitor);
        }
        $this->em->flush();
        return new Response(json_encode($visitor->getToken()), 200);
    }

    #[Route('/api/visit/resetCookieConsent', name: 'api_visit_resetCookieConsent', methods: ['GET'])]
    public function revokeCookieConsent(): Response
    {
        setcookie('_trcc', '', time() - 1, '/');
        return $this->redirectToRoute('home');
    }


} 
