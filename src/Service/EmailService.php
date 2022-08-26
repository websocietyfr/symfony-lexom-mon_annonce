<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail($to, $replyTo, $subject, $text, $html)
    {
        $email = (new Email())
            ->from('no-reply@monannonce.fr')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($replyTo)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->text($text)
            ->html($html);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e);
            // some error prevented the email sending; display an
            // error message or try to resend the message
        }
    }

    public function sendTemplateMail($to, $replyTo, $subject, $template, $data)
    {
        $email = (new TemplatedEmail())
            ->from('no-reply@monannonce.fr')
            ->to($to)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            ->replyTo($replyTo)
            //->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->htmlTemplate($template . '.html.twig')
            ->context([
                'data' => $data
            ]);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            dd($e);
            // some error prevented the email sending; display an
            // error message or try to resend the message
        }
    }
}