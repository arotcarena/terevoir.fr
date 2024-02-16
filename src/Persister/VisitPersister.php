<?php
namespace App\Persister;

use DateTimeZone;
use App\Entity\Visit;
use DateTimeImmutable;
use App\Entity\Visitor;
use App\Repository\VisitRepository;
use App\Repository\VisitorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class VisitPersister
{
    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $request,
        private VisitRepository $visitRepository,
        private VisitorRepository $visitorRepository,
        private TokenGeneratorInterface $tokenGenerator
    )
    {

    }

    public function persist(string $page)
    {
        $session = $this->request->getSession();
        $visitsInSession = $session->get('visit', []);

        if(in_array($page, $visitsInSession))
        {
            return;
        }
        $visitsInSession[] = $page;
        $session->set('visit', $visitsInSession);

        $cookies = $this->request->getCurrentRequest()->cookies;
        if($cookies->get('_tra'))
        {
            $visitor = $this->visitorRepository->findOneByToken($cookies->get('_tra'));
            if($visitor === null)
            {
                throw new Exception('le cookie _tra ne correspond à aucun visiteur en base de donnée');
            }
        }
        else
        {
            $visitorInSession = $session->get('visitor');
            if($visitorInSession)
            {
                $visitor = $this->visitorRepository->findOneByToken($visitorInSession);
                if($visitor === null)
                {
                    throw new Exception('la valeur visitor dans la session ne correspond à aucun visiteur en base de donnée');
                }
            }
            else
            {
                $token = $this->tokenGenerator->generateToken();
                $session->set('visitor', $token);
                $visitor = (new Visitor)->setToken($token);
            }
        }

        $visit = $this->createVisit($visitor, $page);
        $this->em->persist($visit);
        $this->em->flush();
    }


    private function createVisit(Visitor $visitor, string $page): Visit
    {
        $visit = new Visit;
        $visit->setPage($page)
                ->setVisitor($visitor)
                ->setVisitedAt(new DateTimeImmutable('now', new DateTimeZone('Europe/Paris')))
                ;
        return $visit;
    }
}