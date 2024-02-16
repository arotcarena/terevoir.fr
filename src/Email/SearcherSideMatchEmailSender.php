<?php
namespace App\Email;

use App\Entity\Search;
use App\Email\EmailManager;
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

class SearcherSideMatchEmailSender extends EmailManager
{
    public function send(Search $search, Object $lastSearchData):void
    {
        $initialSearcher = $search->getSearcher();
        $receiverFirstName = ucfirst($lastSearchData->myFirstName);
        $searchFirstName = ucfirst($initialSearcher->getFirstName());
        $email = $initialSearcher->getEmail();
        $phone = $initialSearcher->getPhone() ? $initialSearcher->getPhone(): 'non renseigné';

        $email = (new Email())
            ->from('ne-pas-repondre@terevoir.fr')
            ->to($lastSearchData->myEmail)
            ->subject('terevoir.fr : Vous avez retrouvé '.$searchFirstName. ' !')
            ->text(
                'Bonjour '.$receiverFirstName.' ! Vous venez de retrouver '.
                $searchFirstName. 
                '. Voici ses coordonnées - email: '
                .$email.', téléphone: '. $phone . (
                    $search->getMessage() ? ', et voici le message laissé pour vous : '.$search->getMessage() : ''
                )
            )
            ->html($this->twig->render('email/searcher_side_match_email.html.twig', [
                'receiverFirstName' => $receiverFirstName,
                'searchFirstName' => $searchFirstName,
                'email' => $email,
                'phone' => $phone,
                'message' => $search->getMessage()
            ]));

        $this->sendEmail($email);

    }
}