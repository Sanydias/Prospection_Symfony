<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Utilisateur;
use App\Form\UtilisateurFormType;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class HomeController extends AbstractController
{

    /* HOME */

        #[Route('/home/{message?}', name: 'app_home')]
        public function afficherPage($message, ManagerRegistry $doctrine): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = '';
                        $display = "none";
                }

                $timer = [
                    "timer" => 1,
                    "typetimer" => "day"
                ];
                // $actualites = $doctrine->getRepository(Actu::class)->findAll();
                $sites = $doctrine->getRepository(Site::class)->findBy($timer);

            return $this->render("home/index.html.twig", [
                // 'actualites' => $actualites,
                'sites' => $sites,
                'display' => $display,
                'message' => $message
            ]);
        }
        
    /* QUI SOMMES NOUS */

        #[Route('/quisommesnous', name: 'app_qui_sommes_nous')]
        public function quiSommesNous(): Response
        {
            $message = '';
            $display = "none";

            return $this->render("home/quisommesnous.html.twig", [
                'display' => $display,
                'message' => $message
            ]);
        }

    /* ACTUALITÉ */

        #[Route('/actualites', name: 'app_actualites')]
        public function actualite(): Response
        {
            $message = '';
            $display = "none";

            return $this->render("home/actualites.html.twig", [
                'display' => $display,
                'message' => $message
            ]);
        }

    /* INFORMATIONS SITES TEMPORAIRES */

        #[Route('/informationssitestemporaires', name: 'app_informations_sites_temporaires')]
        public function informationsSitesTemporaires(ManagerRegistry $doctrine): Response
        {
            $message = '';
            $display = "none";

            $timer = [
                "timer" => 1,
                "typetimer" => "day"
            ];

            $sites = $doctrine->getRepository(Site::class)->findBy($timer);

            return $this->render("home/informationssitestemporaires.html.twig", [
                'sites' => $sites,
                'display' => $display,
                'message' => $message
            ]);
        }

    /* CONTACT */

        #[Route('/contact', name: 'app_contact')]
        public function contact(): Response
        {
            $message = '';
            $display = "none";

            return $this->render("home/contact.html.twig", [
                'display' => $display,
                'message' => $message
            ]);
        }

    /* erreur */

        #[Route('/erreur', name: 'app_erreur')]
        public function erreur(): Response
        {
            $message = '';
            $display = "none";

            return $this->render("bundles/TwigBundle/Exception/error.html.twig", [
                'display' => $display,
                'message' => $message
            ]);
        }

    /* 403 */

        #[Route('/erreur403', name: 'app_erreur403')]
        public function exception(): Response
        {
            $message = '';
            $display = "none";

            return $this->render("bundles/TwigBundle/Exception/error403.html.twig", [
                'display' => $display,
                'message' => $message
            ]);
        }

    /* 404 */

        #[Route('/erreur404', name: 'app_erreur404')]
        public function notfound(): Response
        {
            $message = '';
            $display = "none";

            return $this->render("bundles/TwigBundle/Exception/error404.html.twig", [
                'display' => $display,
                'message' => $message
            ]);
        }
    
}
