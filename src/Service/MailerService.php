<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService {
    public function __construct(
        #[Autowire('%senderEmail%')] private string $senderEmail,
        private readonly MailerInterface $mailer
    ){}

    public function sendCodePassword($recipe, $code){
        $email = (new Email())
        ->from($this->senderEmail)
        ->to($this->senderEmail)
        ->subject('Code')
        ->text('Code : ' . $code);

        $this->mailer->send($email);
    }
}