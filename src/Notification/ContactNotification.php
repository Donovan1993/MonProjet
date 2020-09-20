<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification
{
    /**
     * @\Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environement
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('Agence:' . $contact->getLogement()->getTitle()))
            ->setFrom('noreply@gmail.com')
            ->setTo('donovan.tchume@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody(
                $this->renderer->render(
                    'emails/contact.html.twig',
                    [
                        'contact' => $contact
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
        // Ici nous enverrons l'e-mail

    }
}
