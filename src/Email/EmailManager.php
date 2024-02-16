<?php
namespace App\Email;

use App\Config;
use Exception;
use Twig\Environment;
use Symfony\Component\Mailer\Mailer;


use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

Abstract class EmailManager
{
    /** @var Mailer */
    protected $mailer;

    public function __construct(
        protected Environment $twig
    )
    {
        $transport = Transport::fromDsn(Config::SMTP);
        $this->mailer = new Mailer($transport);
    }

    protected function sendEmail(Email $email) 
    {
        try {
            $this->mailer->send($email);
        } catch(Exception $e) {
            //
        }
    }
}


