<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CompteController extends AbstractController
{

    /* COMPTE UTILISATEUR */

        #[Route('/compte/{message?}', name: 'app_compte')]
        public function index($message, ManagerRegistry $doctrine): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = 'none';
                        $display = "none";
                }

            return $this->render('compte/compte.html.twig', compact(['message', 'display']));
        }

    /* MODIFICATION COMPTE */

    #[Route('/compte/modification', name: 'app_modification_compte')]
    public function modificationCompte($id, ManagerRegistry $doctrine): Response
    {
        $message = "le compte à bien été modifié";
        $display = "flex";
        
        $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('id' => $id));
        return $this->render('compte/modification.html.twig', [
            'utilisateur' => $utilisateur,
            'display' => $display,
            'message' => $message
        ]);
    }

    /* SUPPRESSION COMPTE */

    #[Route('/compte/suppression', name: 'app_suppression_compte')]
    public function suppressionCompte($id, ManagerRegistry $doctrine): Response
    {
        
        $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('id' => $id));

        $message = "l'utilisateur ".$utilisateur['prenom']." ".$utilisateur['nom']." a bien été supprimé";
        $display = "flex";

        return $this->redirectToRoute('app_home', [
            'utilisateur' => $utilisateur,
            'display' => $display,
            'message' => $message
        ]);
    }

    /* LISTE COMPTE */

        #[Route('/compte/liste', name: 'app_compte_liste')]
        #[IsGranted('ROLE_ADMIN')]
        public function liste(ManagerRegistry $doctrine): Response
        {
            $liste = $doctrine->getRepository(Utilisateur::class)->findAll();
            return $this->render('compte/liste.html.twig', [
                'liste' => $liste
            ]);

        }
}
