<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailService
{
    private readonly Address $santaClauseAddress;

    public function __construct(private readonly MailerInterface $mailer)
    {
        $this->santaClauseAddress = new Address("santa.clause@example.com", "Santa Claus");
    }


    /**
     * @throws TransportExceptionInterface
     */
    public function sendSantaClausMail(User $user): void
    {
        $address = new Address($user->getEmail(), $user->getName());
        $email = (new Email())
            ->from($this->santaClauseAddress)
            ->to($address)
            ->subject('Secret Santa')
            ->text('You have to give a gift to ' . $user->getGiveTo()->getName());
        $this->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function send(Email $email): void
    {
        $this->mailer->send($email);
    }
}
