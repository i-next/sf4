<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\UserService;

use App\Entity\User;


/**
 * Description of MainController
 *
 * @author emmanuel
 */
class MainController extends AbstractController 
{
    
    /**
     * @Route("/", name="app_home")
     */
    public function home(UserService $userService): Response
    {
        if($this->getUser()){
            $userInfo = $userService->getEmailId($this->getUser());
            $this->addFlash('success', $userInfo['email']);
        }
        return $this->render('main/home.html.twig');
    }
    
    /**
     * @Route("/pagetest", name="app_page_test")
     * @return Response
     */
    public function pageTest(): Response
    {
        return $this->render('main/pageTest.html.twig');
    }
    
}
