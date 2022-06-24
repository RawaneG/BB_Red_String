<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class Mailer
{
    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    /**
     *@param User $user
     */
    public function mailSender($user, $subject = "Brazil Burger", $body = "<h1>Bienvenue</h1>")
    {
        $body =
            "
            <h1>Bienvenue</h1>
            <p>Votre compte a été crée avec succès</p>
            ";
        $from = "bb@gmail.com";
        $email = (new Email())
            ->from($from)
            ->to($user->getLogin())
            ->subject($subject)
            ->html($body);
        $this->mailer->send($email);
    }
}
