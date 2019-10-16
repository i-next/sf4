<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User as BaseUser;

/**
 * @ORM\Entity
 * Description of UserComplement
 * @author emmanuel
 */
class UserComplement extends BaseUser
{
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $firstName;
    
    function getFirstName() {
        return $this->firstName;
    }

    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }


}
