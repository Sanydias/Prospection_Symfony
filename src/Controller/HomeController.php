<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Site;
use App\Form\ContactFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /* AVERTISSEMENT LOI */

        #[Route('/', name: 'app_loi')]
        public function loi(): Response
        {
            return $this->render("loi.html.twig");
        }

    /* HOME */

        #[Route('/home/{contenu?}', name: 'app_home')]
        public function afficherPage($contenu, ManagerRegistry $doctrine): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                if (isset($contenu)) {
                    $message = [
                        'display' => 'flex',
                        'contenu' => $contenu,
                        'bouton' => FALSE,
                        'lien' => 'none'
                    ];
                }else{
                    $message = [
                        'display' => 'none',
                        'contenu' => 'none',
                        'bouton' => FALSE,
                        'lien' => 'none'
                    ];
                }

                $timer = [
                    "timer" => 1,
                    "typetimer" => "day"
                ];
                $actualites = $doctrine->getRepository(Actualite::class)->findBy(array('afficher' => '1'));
                $sites = $doctrine->getRepository(Site::class)->findBy($timer);

            return $this->render("home/index.html.twig", [
                'actualites' => $actualites,
                'sites' => $sites,
                'message' => $message
            ]);
        }
        
    /* QUI SOMMES NOUS */

        #[Route('/quisommesnous', name: 'app_qui_sommes_nous')]
        public function quiSommesNous(): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            return $this->render("home/quisommesnous.html.twig", compact(['message']));
        }

    /* ACTUALITÉ */

        #[Route('/actualites', name: 'app_actualites')]
        public function actualite(ManagerRegistry $doctrine): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            $actualites = $doctrine->getRepository(Actualite::class)->findBy(array('afficher' => '1'));


            return $this->render("home/actualites.html.twig", [
                'message' => $message,
                'actualites' => $actualites
            ]);
        }

    /* INFORMATIONS SITES TEMPORAIRES */

        #[Route('/informationssitestemporaires', name: 'app_informations_sites_temporaires')]
        public function informationsSitesTemporaires(ManagerRegistry $doctrine): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            $timer = [
                "timer" => 1,
                "typetimer" => "day"
            ];

            $sites = $doctrine->getRepository(Site::class)->findBy($timer);

            return $this->render("home/informationssitestemporaires.html.twig", [
                'sites' => $sites,
                'message' => $message
            ]);
        }

    /* CONTACT */

        #[Route('/contact', name: 'app_contact')]
        public function contact(): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];
                
            $form = $this->createForm(ContactFormType::class, null,[
                'action' => $this->generateUrl('app_contact'),
                'method' => 'POST'
            ]);

            return $this->render("home/contact.html.twig", [
                'message' => $message,
                'form' => $form
            ]);
        }

    /* erreur */

        #[Route('/erreur', name: 'app_erreur')]
        public function erreur(): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            return $this->render("bundles/TwigBundle/Exception/error.html.twig", [
                'message' => $message,
                'erreur' => ' '
            ]);
        }

    /* 403 */

        #[Route('/erreur403', name: 'app_erreur403')]
        public function exception(): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            return $this->render("bundles/TwigBundle/Exception/error.html.twig", [
                'message' => $message,
                'erreur' => '403'
            ]);
        }

    /* 404 */

        #[Route('/erreur404', name: 'app_erreur404')]
        public function notfound(): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            return $this->render("bundles/TwigBundle/Exception/error.html.twig", [
                'message' => $message,
                'erreur' => '404'
            ]);
        }
    
}
