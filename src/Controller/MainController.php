<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * MainController
 *
 * @author emmanuel euchin
 */
class MainController extends AbstractController 
{
    
    /**
     * @Route("/", name="app_home")
     */
    public function mainPage(): Response
    {
         return $this->render('main/home.html.twig', [
            
            ]);
    }
    
}
