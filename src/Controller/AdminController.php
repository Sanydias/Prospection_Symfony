<?php

namespace App\Controller;

use App\Entity\Site;
use App\Entity\Utilisateur;
use App\Form\AjoutSiteFormType;
use App\Form\ModificationDroitUtilisateurFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {

        /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

            if (isset($message)) {
                $display = "flex";
            }else{
                    $message = 'none';
                    $display = "none";
            }

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'message' => $message,
            'display' => $display
        ]);
    }

    /* LISTE COMPTE */

        #[Route('/admin/compte/liste/{message?}', name: 'app_admin_compte_liste')]
        public function listeCompte(ManagerRegistry $doctrine): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
    
                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = 'none';
                        $display = "none";
                }

            $liste = $doctrine->getRepository(Utilisateur::class)->findAll();
            return $this->render('admin/compte/liste.html.twig', [
                'liste' => $liste,
                'message' => $message,
                'display' => $display
            ]);

        }
        
    /* MODIFICATION COMPTE */

        #[Route('/admin/compte/modifier/{id}', name: 'app_admin_compte_modifier')]
        public function droit($id, ManagerRegistry $doctrine, Request $request): Response
        {
            $message = 'none';
            $display = "none";
                
            $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('id' => $id));
            
            $manager = $doctrine->getManager();
            $form = $this->createForm(ModificationDroitUtilisateurFormType::class, $utilisateur,[
                'action' => $this->generateUrl('app_admin_compte_modifier', ['id' => $id]),
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $utilisateur = $form->getData();

                if ($form->get("roles")->getData() == 'Administrateur') {
                    $utilisateur -> setRoles(['ROLE_ADMIN']);
                }else if ($form->get("roles")->getData() == 'Utilisateur') {
                    $utilisateur -> setRoles(['ROLE_USER']);
                }else{
                    $utilisateur -> setRoles(array('ROLE_USER'));
                }

                $manager->persist($utilisateur);
                $manager->flush();

                $message = "le compte à bien été modifié";
                $display = "flex";
                return $this->redirectToRoute('app_admin_compte_liste', ["message" => $message]);
            }

            return $this->render('admin/compte/modifier.html.twig', [
                'utilisateur' => $utilisateur,
                'form' => $form,
                'message' => $message,
                'display' => $display
            ]);

        }

    /* SUPPRESSION COMPTE */

        #[Route('/admin/compte/supprimer/{id}', name: 'app_admin_compte_supprimer')]
        public function supprimerCompte($id, ManagerRegistry $doctrine): Response
        {

            $message = "le compte a bien été supprimé";
            $display = "flex";

            $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('id' => $id));
            
            $manager =$doctrine->getManager();
            $manager->remove($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('app_admin_compte_liste', [
                'display' => $display,
                'message' => $message
            ]);
        }

    /* LISTE SITE */

        #[Route('/admin/site/liste/{message?}', name: 'app_admin_site_liste')]
        public function listeSite($message, ManagerRegistry $doctrine): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
    
                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = 'none';
                        $display = "none";
                }

            $liste = $doctrine->getRepository(Site::class)->findAll();
            return $this->render('admin/site/liste.html.twig', [
                'liste' => $liste,
                'message' => $message,
                'display' => $display
            ]);

        }
        
    /* AJOUT SITE */

        #[Route('/admin/site/ajouter', name: 'app_admin_site_ajouter')]
        public function ajouterSite(ManagerRegistry $doctrine, Request $request): Response
        {
            $message = 'none';
            $display = "none";
                

            $manager = $doctrine->getManager();
            $site = new Site();
            $form = $this->createForm(AjoutSiteFormType::class, $site,[
                'action' => $this->generateUrl('app_admin_site_ajouter'),
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $site = $form->getData();

                $site -> setDepartement($form->get("departement")->getData());
                $site -> setCommune($form->get("commune")->getData());
                $site -> setLieuxdit($form->get("lieuxdit")->getData());
                $site -> setInterethistorique($form->get("interethistorique")->getData());
                $site -> setLien($form->get("lien")->getData());
                $site -> setTimer($form->get("timer")->getData());

                if ($form->get("timer")->getData() == 1) {
                    $site -> setTypetimer($form->get("typetimer")->getData());
                    $site -> setTempsinitial();
                    $site -> setTempsrestant();
                }

                $manager->persist($site);

                $display = "flex";
                $message = "le site a bien été ajouté";

                $count = $form->get("count")->getData();
                if ($count > 0) {
                    for ($i=0; $i < $count; $i++) {
                        $addSite = new Site();
                        $id_of_site = strval($i+1);
                        $addSite -> setDepartement($request->getPayload()->get("departement_".$id_of_site));
                        $addSite -> setCommune($request->getPayload()->get("commune_".$id_of_site));
                        $addSite -> setLieuxdit($request->getPayload()->get("lieuxdit_".$id_of_site));
                        $addSite -> setInterethistorique($request->getPayload()->get("interethistorique_".$id_of_site));
                        $addSite -> setLien($request->getPayload()->get("lien_".$id_of_site));
                        $addSite -> setTimer($request->getPayload()->get("timer_".$id_of_site));
        
                        if ($request->getPayload()->get("timer_".$id_of_site) == 1) {
                            $addSite -> setTypetimer($request->getPayload()->get("typetimer_".$id_of_site));
                            // $addSite -> setTempsinitial();
                            // $addSite -> setTempsrestant();
                        }
                        $multipleSite[$i] = $addSite;

                        $manager->persist($multipleSite[$i]);
                        
                        $message = "les sites ont bien été ajouté";
                    }
                }

                $manager->flush();
                return $this->redirectToRoute('app_admin_site_liste', ["message" => $message]);
            }

            return $this->render('admin/site/ajouter.html.twig', [
                'form' => $form,
                'message' => $message,
                'display' => $display
            ]);

        }
        
    /* MODIFICATION SITE */

        #[Route('/admin/site/modifier/{id}', name: 'app_admin_site_modifier')]
        public function modifierSite($id, ManagerRegistry $doctrine, Request $request): Response
        {
            $message = 'none';
            $display = "none";
                
            $site = $doctrine->getRepository(Site::class)->findOneBy(array('id' => $id));
            
            $manager = $doctrine->getManager();
            $form = $this->createForm(AjoutSiteFormType::class, $site,[
                'action' => $this->generateUrl('app_admin_site_modifier', ['id' => $id]),
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $site = $form->getData();

                $site -> setDepartement($form->get("departement")->getData());
                $site -> setCommune($form->get("commune")->getData());
                $site -> setLieuxdit($form->get("lieuxdit")->getData());
                $site -> setInterethistorique($form->get("interethistorique")->getData());
                $site -> setLien($form->get("lien")->getData());
                $site -> setTimer($form->get("timer")->getData());
                if ($form->get("timer")->getData() == 1) {
                    $site -> setTypetimer($form->get("typetimer")->getData());
                    $site -> setTempsinitial();
                    $site -> setTempsrestant();
                }

                $manager->persist($site);
                $manager->flush();

                $message = "le compte à bien été modifié";
                $display = "flex";
                return $this->redirectToRoute('app_admin_site_liste', ["message" => $message]);
            }

            return $this->render('admin/site/modifier.html.twig', [
                'site' => $site,
                'form' => $form,
                'message' => $message,
                'display' => $display
            ]);

        }

    /* SUPPRESSION SITE */

        #[Route('/admin/site/supprimer/{id}', name: 'app_admin_site_supprimer')]
        public function supprimerSite($id, ManagerRegistry $doctrine): Response
        {

            $message = "le site a bien été supprimé";
            $display = "flex";

            $site = $doctrine->getRepository(Site::class)->findOneBy(array('id' => $id));
            
            $manager =$doctrine->getManager();
            $manager->remove($site);
            $manager->flush();

            return $this->redirectToRoute('app_admin_site_liste', [
                'display' => $display,
                'message' => $message
            ]);
        }

}
