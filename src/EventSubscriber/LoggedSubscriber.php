<?php



namespace App\EventSubscriber;

use App\Entity\User;
use App\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Description of RegistrationNotifySubscriber
 *
 * @author emmanuel euchin
 */
class LoggedSubscriber implements EventSubscriberInterface
{
    
    
    
    
    

    public function __construct()
    {
        
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // le nom de l'event et le nom de la fonction qui sera déclenché
            Events::USER_LOGGED => 'onUserLogged',
            
        ];
    }

    public function onUserLogged(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
        dump($user);die();
        
    }
}
