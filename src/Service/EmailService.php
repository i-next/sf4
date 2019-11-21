<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Description of EmailService
 *
 * @author emmanuel euchin
 */
class EmailService {
   
    private $mailer;
    private $params;

    public function __construct(\Swift_Mailer $mailer,ParameterBagInterface $params)
    {
        $this->mailer = $mailer;
        $this->params = $params;
    }
    
    public function userConfirmation(string $dest) : bool
   {
        $message = (new \Swift_Message())
            ->setSubject('Enregistrement de votre profil')
            ->setFrom($this->params->get('app.email_sender'))
            ->setTo($dest)
            ->setBody('Votre compte a bien été créé',
                'text/html'
        );
        return $this->mailer->send($message);
  }
    

    
}
