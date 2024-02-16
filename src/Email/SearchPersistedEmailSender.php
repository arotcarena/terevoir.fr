<?php
namespace App\Email;

use App\Entity\Search;
use App\Entity\Searcher;
use App\Email\EmailManager;
use Symfony\Component\Mime\Email;


class SearchPersistedEmailSender extends EmailManager
{
    public function send(Search $search):void
    {
        $searcher = $search->getSearcher();
        $receiverFirstName = ucfirst($searcher->getFirstName());
        $searchFirstName = ucfirst($search->getFirstName());

        $email = (new Email())
            ->from('ne-pas-repondre@terevoir.fr')
            ->to($searcher->getEmail())
            ->subject('terevoir.fr : Récapitulatif de votre recherche')
            ->text(
                'Bonjour '.$receiverFirstName.
                ' ! Votre recherche est bien enregistrée dans notre base de donnée, dès que '
                .$searchFirstName.
                ' essaiera de vous retrouver à son tour, nous vous en aviserons.'
            )
            ->html($this->twig->render('email/search_persisted_email.html.twig', [
                'receiverFirstName' => $receiverFirstName,
                'searchFirstName' => $searchFirstName,
                'message' => $search->getMessage()
            ]));

        $this->sendEmail($email);

    }
}