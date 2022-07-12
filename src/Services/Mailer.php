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

    public function mailSender($user, $subject = "Brazil Burger")
    {
        $from = "bb@gmail.com";
        $email = (new Email())
            ->from($from)
            ->to($user->getLogin())
            ->subject($subject)
            ->html($this->twig->render(
                'mailer/index.html.twig',
                [
                    "user" => $user
                ]
            ));
        $this->mailer->send($email);
    }
}
