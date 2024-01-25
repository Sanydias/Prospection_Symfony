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

        /* PROFIL */

            #[Route('/compte/profil/{message?}', name: 'app_profil')]
            public function profil($message, ManagerRegistry $doctrine): Response
            {

                /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                    if (isset($message)) {
                        $display = "flex";
                    }else{
                            $message = 'none';
                            $display = "none";
                    }

                return $this->render('compte/profil.html.twig', compact(['message', 'display']));
            }

        /* FAVORIS */

            #[Route('/compte/favoris/{message?}', name: 'app_favoris')]
            public function favoris($message, ManagerRegistry $doctrine): Response
            {

                /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                    if (isset($message)) {
                        $display = "flex";
                    }else{
                            $message = 'none';
                            $display = "none";
                    }

                return $this->render('compte/favoris.html.twig', compact(['message', 'display']));
            }

        /* ACHATS */

            #[Route('/compte/achats/{message?}', name: 'app_achats')]
            public function achats($message, ManagerRegistry $doctrine): Response
            {

                /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                    if (isset($message)) {
                        $display = "flex";
                    }else{
                            $message = 'none';
                            $display = "none";
                    }

                return $this->render('compte/achats.html.twig', compact(['message', 'display']));
            }

        /* DISCUSSIONS */

            #[Route('/compte/discussions/{message?}', name: 'app_discussions')]
            public function discussions($message, ManagerRegistry $doctrine): Response
            {

                /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                    if (isset($message)) {
                        $display = "flex";
                    }else{
                            $message = 'none';
                            $display = "none";
                    }

                return $this->render('compte/discussions.html.twig', compact(['message', 'display']));
            }

        /* PARAMÈTRES */

            #[Route('/compte/parametres/index/{message?}', name: 'app_parametres')]
            public function parametres($message, ManagerRegistry $doctrine): Response
            {

                /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                    if (isset($message)) {
                        $display = "flex";
                    }else{
                            $message = 'none';
                            $display = "none";
                    }

                return $this->render('compte/parametres/index.html.twig', compact(['message', 'display']));
            }
                                    
            /*if ($typeDePreference !== '') {
                $requeteId = $BDD -> prepare("SELECT id FROM utilisateur WHERE email= :email");
                $requeteId -> execute(array('email' => $email));
                $data = $requeteId -> fetch();
                $id_utilisateur = $data["id"];
                if ($region) {
                    $lieu = $region;
                } elseif ($departement) {
                    $lieu = $departement;
                }elseif ($ville) {
                    $lieu = $ville;
                }
                if ($lieu !== '') {
                        $requeteOptionnel = $BDD -> prepare("INSERT INTO preference (type_preference, lieu, id_utilisateur) VALUES (:type_preference, :lieu, :id_utilisateur)");
                        $requeteOptionnel -> execute(array( 'type_preference' => $typeDePreference,
                                                            'lieu' => $lieu,
                                                            'id_utilisateur' => $id_utilisateur));
                }
            }*/

            /* MODIFICATION COMPTE */

                #[Route('/compte/parametres/modification/{id}', name: 'app_modification_compte')]
                public function modificationCompte($id, ManagerRegistry $doctrine): Response
                {
                    $message = "le compte à bien été modifié";
                    $display = "flex";
                    
                    $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('id' => $id));
                    return $this->render('compte/parametres/modification.html.twig', [
                        'utilisateur' => $utilisateur,
                        'display' => $display,
                        'message' => $message
                    ]);
                }

            /* SUPPRESSION COMPTE */

                #[Route('/compte/parametres/suppression/{id}', name: 'app_suppression_compte')]
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
