<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function setTemplatedMail(string $adressFrom, string $adressName, string $to, string $subject, string $htmlTemplate, array $context = [], bool $send = false): ?TemplatedEmail
    {
        $email = (new TemplatedEmail())
            ->from(new Address($adressFrom, $adressName))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($htmlTemplate)
            ->context($context)
        ;

        if ($send) {
            return $this->mailer->send($email);
        } else {
            return $email;
        }
    }
}