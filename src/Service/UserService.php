<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of UserService
 *
 * @author emmanuel
 */
class UserService {
    
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function getEmailId(User $user): Array
    {
        $repository = $this->em->getRepository(User::class);
        $userInfo = $repository->find($user);
        $data = [
            'id' => $userInfo->getId(),
            'email' => $userInfo->getEmail()
        ];
        return $data;
    }
}
