<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Entity\Site;
use App\Entity\Utilisateur;
use App\Form\ActualiteFormType;
use App\Form\AjoutSiteFormType;
use App\Form\ModificationDroitUtilisateurFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
                    // $site -> setTempsinitial();
                    // $site -> setTempsrestant();
                }

                $manager->persist($site);
                $manager->flush();

                $message = "le site à bien été modifié";
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

    /* LISTE ACTUALITÉ */

        #[Route('/admin/actualite/liste/{message?}', name: 'app_admin_actualite_liste')]
        public function listeActualite($message, ManagerRegistry $doctrine): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
    
                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = 'none';
                        $display = "none";
                }

            $liste = $doctrine->getRepository(Actualite::class)->findAll();
            return $this->render('admin/actualite/liste.html.twig', [
                'liste' => $liste,
                'message' => $message,
                'display' => $display
            ]);

        }
        
    /* AJOUT ACTUALITÉ */

        #[Route('/admin/actualite/ajouter', name: 'app_admin_actualite_ajouter')]
        public function ajouterActualite(ManagerRegistry $doctrine, SluggerInterface $slugger, Request $request): Response
        {
            $message = 'none';
            $display = "none";
                

            $manager = $doctrine->getManager();
            $actualite = new Actualite();
            $form = $this->createForm(ActualiteFormType::class, $actualite,[
                'require_image' => true,
                'action' => $this->generateUrl('app_admin_actualite_ajouter'),
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $actualite = $form->getData();
                $actualite -> setTitre($form->get("titre")->getData());
                $image = $form->get("image")->getData();
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-uniqid-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('ActualitefileDirectory'),//fileDirectory
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $actualite -> setImage($newFilename);
                $actualite -> setLien($form->get("lien")->getData());
                $actualite -> setAfficher($form->get("afficher")->getData());

                if ($form->get("afficher")->getData() == 1) {
                    $actualite -> setPriorite($form->get("priorite")->getData());
                }
                $manager->persist($actualite);
                $manager->flush();

                $display = "flex";
                $message = "l'actualité a bien été ajouté";
                return $this->redirectToRoute('app_admin_actualite_liste', ["message" => $message]);
            }

            return $this->render('admin/actualite/ajouter.html.twig', [
                'form' => $form,
                'message' => $message,
                'display' => $display
            ]);

        }
        
    /* MODIFICATION ACTUALITÉ */

        #[Route('/admin/actualite/modifier/{id}', name: 'app_admin_actualite_modifier')]
        public function modifierActualite($id, ManagerRegistry $doctrine, SluggerInterface $slugger, Request $request): Response
        {
            $message = 'none';
            $display = "none";
                
            $actualite = $doctrine->getRepository(Actualite::class)->findOneBy(array('id' => $id));
            
            $manager = $doctrine->getManager();
            $form = $this->createForm(ActualiteFormType::class, $actualite,[
                'require_image' => false,
                'action' => $this->generateUrl('app_admin_actualite_modifier', ['id' => $id]),
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                
                $actualite = $form->getData();
                $actualite -> setTitre($form->get("titre")->getData());
                if ($form->get("image")->getData()) {
                    # code...
                    $image = $form->get("image")->getData();
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-uniqid-'.uniqid().'.'.$image->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $image->move(
                            $this->getParameter('ActualitefileDirectory'),//fileDirectory
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'imagename' property to store the PDF file name
                    // instead of its contents
                    $actualite -> setImage($newFilename);
                }
                $actualite -> setLien($form->get("lien")->getData());
                $actualite -> setAfficher($form->get("afficher")->getData());

                if ($form->get("afficher")->getData() == 1) {
                    $actualite -> setPriorite($form->get("priorite")->getData());
                }
                $manager->persist($actualite);
                $manager->flush();

                $message = "l'actualité à bien été modifié";
                $display = "flex";
                return $this->redirectToRoute('app_admin_actualite_liste', ["message" => $message]);
            }

            return $this->render('admin/actualite/modifier.html.twig', [
                'actualite' => $actualite,
                'form' => $form,
                'message' => $message,
                'display' => $display
            ]);

        }

    /* SUPPRESSION ACTUALITÉ */

        #[Route('/admin/actualite/supprimer/{id}', name: 'app_admin_actualite_supprimer')]
        public function supprimerActualite($id, ManagerRegistry $doctrine): Response
        {

            $message = "l'actualité a bien été supprimé";
            $display = "flex";

            $actualite = $doctrine->getRepository(Actualite::class)->findOneBy(array('id' => $id));
            
            $manager =$doctrine->getManager();
            $manager->remove($actualite);
            $manager->flush();

            return $this->redirectToRoute('app_admin_actualite_liste', [
                'display' => $display,
                'message' => $message
            ]);
        }

    /* LISTE IMAGES */

        #[Route('/admin/images/liste/{message?}', name: 'app_admin_images_liste')]
        public function listeImages($message, ManagerRegistry $doctrine): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
    
                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = 'none';
                        $display = "none";
                }

            $compteImageDirectory = $this->getParameter('fileDirectory');
            $actualiteImageDirectory = $this->getParameter('ActualitefileDirectory');
            $finder = new Finder();
            $finder->in([$compteImageDirectory, $actualiteImageDirectory]);

            // check if there are any search results
            if ($finder->hasResults()) {
                $count = 0;
                foreach ($finder as $file) {
                    // $absoluteFilePath = $file->getRealPath();
                    // $filePathNameWithExtension = $file->getRelativePathname();
                    $fileNameWithExtension = $file->getFilename();

                    $actualite = $doctrine->getRepository(Actualite::class)->findOneBy(array('image' => $fileNameWithExtension));
                    $compte = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('photodeprofil' => $fileNameWithExtension));
                    if ($actualite){
                        $FullFilePath = $file->getPath();
                        $utilise = "Oui";
                        $nomtable = "actualite";
                        $idelement = $actualite->getId();
                    } else if ($compte){
                        $FullFilePath = $file->getPath();
                        $utilise = "Oui";
                        $nomtable = "utilisateur";
                        $idelement = $compte->getId();
                    }else{
                        $FullFilePath = $file->getPath();
                        $utilise = "Non";
                        $FilePath = explode("/", $FullFilePath);
                        $imageDirectory = $FilePath[3];
                        if ($imageDirectory == "ACTUALITE") {
                            $nomtable = "actualite";
                        } elseif ($imageDirectory == "PP") {
                            $nomtable = "utilisateur";
                        } else {
                            $nomtable = $imageDirectory;
                        }
                        $idelement = "aucun";
                    }
                    $FilePath = explode("/", $FullFilePath);
                    $absoluteFilePath = $FilePath[2] . "/" . $FilePath[3];
                    $element = [
                        "name" => $fileNameWithExtension,
                        "image" => $absoluteFilePath . '/' . $fileNameWithExtension,
                        "utilise" => $utilise,
                        "nomtable" => $nomtable,
                        "idelement" => $idelement,
                        "id" => $count
                    ];
                    $liste[$count] = $element;
                    $count++;
                }
            }else{
                $liste = [];
            }
            

            return $this->render('admin/images/liste.html.twig', [
                'liste' => $liste,
                'message' => $message,
                'display' => $display
            ]);

        }

    /* SUPPRESSION IMAGES */

        #[Route('/admin/images/supprimer/{name}/{directory}', name: 'app_admin_images_supprimer')]
        public function supprimerImages($name, $directory, ManagerRegistry $doctrine): Response
        {
            if ($directory == "utilisateur") {
                $imageDirectory = $this->getParameter('fileDirectory');
                $compte = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('photodeprofil' => $name));
                $compte->setPhotoDeProfil(NULL);
            
                $manager =$doctrine->getManager();
                $manager->persist($compte);
                $manager->flush();
            } else {
                $compteImageDirectory = $this->getParameter('fileDirectory');
                $actualiteImageDirectory = $this->getParameter('ActualitefileDirectory');
                $finder = new Finder();
                $finder->in([$compteImageDirectory, $actualiteImageDirectory])->files()->name($name);
                if ($finder->hasResults()) {
                    foreach ($finder as $file) {
                        $FullFilePath = $file->getPath();
                        $FilePath = explode("/", $FullFilePath);
                        $imageDirectory = $FilePath[2] . "/" . $FilePath[3];
                    }
                }else{
                    $imageDirectory = "";
                }
            }
            // Je crée une instance de kla classe fileSystem
                $fileSystem = new Filesystem();
            //Je supprime l'image du dossier
                $fileSystem->remove($imageDirectory . "/" . $name);

                $message = "l'image a bien été supprimé";
                $display = "flex";
            

            return $this->redirectToRoute('app_admin_images_liste', [
                'display' => $display,
                'message' => $message
            ]);
        }

    /* LISTE ACHATS */

        #[Route('/admin/achat/liste/{message?}', name: 'app_admin_achat_liste')]
        public function listeAchat($message, ManagerRegistry $doctrine): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
    
                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = 'none';
                        $display = "none";
                }

            return $this->render('admin/achat/liste.html.twig', [
                'liste' => '$liste',
                'message' => $message,
                'display' => $display
            ]);

        }

}
