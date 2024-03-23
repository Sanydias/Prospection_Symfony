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
                $actualites = $doctrine->getRepository(Actualite::class)->findBy(array('afficher' => '1'));
                $sites = $doctrine->getRepository(Site::class)->findBy($timer);

            return $this->render("home/index.html.twig", [
                'actualites' => $actualites,
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
        public function actualite(ManagerRegistry $doctrine): Response
        {
            $message = '';
            $display = "none";

            $actualites = $doctrine->getRepository(Actualite::class)->findBy(array('afficher' => '1'));


            return $this->render("home/actualites.html.twig", [
                'display' => $display,
                'message' => $message,
                'actualites' => $actualites
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
        public function contact(Request $request, MailerInterface $mailer): Response
        {
            $message = '';
            $display = "none";
            
                
            $contact = null;
            $form = $this->createForm(ContactFormType::class, $contact,[
                'action' => $this->generateUrl('app_contact'),
                'method' => 'POST'
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $email = (new Email())
                    ->from($form->get('email')->getData())
                    ->to('marie.dumas2002@gmail.com')
                    ->subject($form->get('sujet')->getData())
                    ->text($form->get('message')->getData());
                try {
                    $mailer->send($email);
                    $message = 'Votre mail a bien été envoyé !';
                } catch (TransportExceptionInterface $e) {
                    $message = "Il y a eu un problème lors de l'envoi de votre mail !";
                }
                $display = "flex";
            }

            return $this->render("home/contact.html.twig", [
                'display' => $display,
                'message' => $message,
                'form' => $form
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
                'message' => $message,
                'erreur' => ' '
            ]);
        }

    /* 403 */

        #[Route('/erreur403', name: 'app_erreur403')]
        public function exception(): Response
        {
            $message = '';
            $display = "none";

            return $this->render("bundles/TwigBundle/Exception/error.html.twig", [
                'display' => $display,
                'message' => $message,
                'erreur' => '403'
            ]);
        }

    /* 404 */

        #[Route('/erreur404', name: 'app_erreur404')]
        public function notfound(): Response
        {
            $message = '';
            $display = "none";

            return $this->render("bundles/TwigBundle/Exception/error.html.twig", [
                'display' => $display,
                'message' => $message,
                'erreur' => '404'
            ]);
        }
    
}
