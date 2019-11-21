<?php

namespace App\Validator;


use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
/**
 * Description of EmailValidator
 *
 * @author emmanuel euchin 
 */
class EmailValidator {
    
    
     private $em;

   public function __construct(EntityManager $em) { // i guess it's EntityManager the type
       $this->em = $em;
   }
     
    
    public function validate(User $user)
    {
       
        $savedUser = $this->em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
        dump($savedUser);die();
    }
}
