<?php
namespace App\Email;

use App\Email\EmailManager;
use App\Entity\Searcher;
use Symfony\Component\Mime\Email;


/**
 * lastSearchData /
 * 
 * searchFirstName = '';
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
 */
class MatchEmailSender extends EmailManager
{
    public function send(Searcher $initialSearcher, Object $lastSearchData):void
    {
        $searchFirstName = ucfirst($lastSearchData->myFirstName);
        $receiverFirstName = ucfirst($initialSearcher->getFirstName());
        $email = $lastSearchData->myEmail;
        $phone = $lastSearchData->myPhone !== '' ? $lastSearchData->myPhone: 'non renseigné';

        $email = (new Email())
            ->from('ne-pas-repondre@terevoir.fr')
            ->to($initialSearcher->getEmail())
            ->subject('terevoir.fr : '.$searchFirstName. ' vient de vous rechercher à son tour !')
            ->text(
                'Bonjour '.$receiverFirstName.' ! '.
                $searchFirstName. 
                ' vient de vous rechercher à son tour sur terevoir.fr ! Voici ses coordonnées - email: '
                .$email.', téléphone: '. $phone
            )
            ->html($this->twig->render('email/match_email.html.twig', [
                'receiverFirstName' => $receiverFirstName,
                'searchFirstName' => $searchFirstName,
                'email' => $email,
                'phone' => $phone
            ]));

        $this->sendEmail($email);

    }
}