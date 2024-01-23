<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /* CONNEXION */

        #[Route(path: '/connexion/{message?}', name: 'app_connexion')]
        public function login($message, AuthenticationUtils $authenticationUtils): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = 'none';
                        $display = "none";
                }

            // if ($this->getUser()) {
            //     return $this->redirectToRoute('target_path');
            // }

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/connexion.html.twig', [
                'display' => $display,
                'message' => $message,
                'last_username' => $lastUsername,
                'error' => $error
            ]);
        }
    /* DÉCONNEXION */

        #[Route(path: '/deconnexion', name: 'app_deconnexion')]
        public function logout(): void
        {
            throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        }
        
}
