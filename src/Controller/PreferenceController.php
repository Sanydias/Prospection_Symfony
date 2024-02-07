<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreferenceController extends AbstractController
{
    #[Route('/compte/parametres/preference', name: 'app_preference')]
    public function index(): Response
    {
        /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

            if (isset($message)) {
                $display = "flex";
            }else{
                    $message = 'none';
                    $display = "none";
            }

        return $this->render('/compte/parametres/preference/index.html.twig', [
            'controller_name' => 'PreferenceController',
            'message' => $message,
            'display' => $display
        ]);
    }
}
