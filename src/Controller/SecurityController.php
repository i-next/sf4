<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Events;
use App\Service\EmailService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Log\LoggerInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //    $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
    
    /**
     * @Route("/error", name="app_error")
     */
    public function errorPage(Request $request){
        $message = $request->query->get('message');
        return $this->render('errors/error.html.twig',[
            'message' => $message,
        ]);
}
    
    /**
     * @Route("/signup", name="app_signup")
     * @param Request $request
     * @return Response
     */

    public function signup(Request $request,ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder, LoggerInterface $logger, EventDispatcherInterface $eventDispatcher, \Swift_Mailer $mailer, EmailService $emailService): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $errors = $validator->validate($user);
            
            
                $user->repassword = $request->request->get('user')['repassword'];
                $user->setRoles(array('ROLE_USER'));
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                        )
                );
                $logger->info("New user:".$form->get('email')->getData());
                
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                

                $emailService->userConfirmation($form->get('email')->getData());
                $event = new GenericEvent($user);
                $eventDispatcher->dispatch( $event, Events::USER_REGISTERED);
                
                return $this->redirectToRoute('app_login');
            
        }
        return $this->render('registration/register.html.twig',[
            'registrationForm' => $form->createView(),
        ]);
    }
}
