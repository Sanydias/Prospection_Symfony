<?php

namespace App\Controller;

use App\Entity\Favori;
use App\Entity\Site;
use App\Entity\Utilisateur;
use App\Form\ModificationUtilisateurFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Security;

class CompteController extends AbstractController
{

    /* COMPTE UTILISATEUR */

        /* PROFIL */

            #[Route('/compte/profil/{contenu?}', name: 'app_profil')]
            public function profil($contenu, ManagerRegistry $doctrine): Response
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

                return $this->render('compte/profil.html.twig', compact(['message']));
            }

        /* FAVORIS */

            #[Route('/compte/favoris/{contenu?}', name: 'app_favoris')]
            public function favoris($contenu, ManagerRegistry $doctrine): Response
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

                    $liste = $doctrine->getRepository(Favori::class)->findBy(['utilisateur' => ($this->getUser())], ['ranking' => 'ASC']);

                return $this->render('compte/favoris.html.twig', compact(['message', 'liste']));
            }

        /* ACHATS */

            #[Route('/compte/achats/{contenu?}', name: 'app_achats')]
            public function achats($contenu, ManagerRegistry $doctrine): Response
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

                return $this->render('compte/achats.html.twig', compact(['message']));
            }

        /* DISCUSSIONS */

            #[Route('/compte/discussions/{contenu?}', name: 'app_discussions')]
            public function discussions($contenu, ManagerRegistry $doctrine): Response
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

                return $this->render('compte/discussions.html.twig', compact(['message']));
            }

        /* PARAMÈTRES */

            /* ACCESSIBILITÉ */

                #[Route('/compte/parametres/accessibilite', name: 'app_accessibilite')]
                public function accessibilite(): Response
                {
                    $message = [
                        'display' => 'none',
                        'contenu' => 'none',
                        'bouton' => FALSE,
                        'lien' => 'none'
                    ];

                    return $this->render('compte/parametres/accessibilite.html.twig', compact(['message']));
                }

            /* ACCESSIBILITÉ */

                #[Route('/compte/parametres/confidentialite', name: 'app_confidentialite')]
                public function confidentialite(): Response
                {
                    $message = [
                        'display' => 'none',
                        'contenu' => 'none',
                        'bouton' => FALSE,
                        'lien' => 'none'
                    ];

                    return $this->render('compte/parametres/confidentialite.html.twig', [
                        'message' => $message
                    ]);
                }

            /* MODIFICATION COMPTE */

                #[Route('/compte/parametres/modification/{id}/{contenu?}', name: 'app_modification_compte')]
                public function modificationCompte($id, ManagerRegistry $doctrine, SluggerInterface $slugger, Request $request, $contenu): Response
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

                    $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('id' => $id));
                    
                    $manager = $doctrine->getManager();
                    $form = $this->createForm(ModificationUtilisateurFormType::class, $utilisateur,[
                        'action' => $this->generateUrl('app_modification_compte', ['id' => $id]),
                        'method' => 'POST',
                    ]);
                    $form->handleRequest($request);
                    if ($form->isSubmitted() && $form->isValid()) {
                        
                        $utilisateur = $form->getData();
                
                        $nom = $form->get("nom")->getData();
                        $nom = strtoupper("$nom");
                        $utilisateur -> setNom($nom);
        
                        $prenom = $form->get("prenom")->getData();
                        $prenom = ucfirst("$prenom");
                        $utilisateur -> setPrenom($prenom);
        
                        $utilisateur -> setSexe($form->get("sexe")->getData());
        
                        $utilisateur -> setDateDeNaissance($form->get("datedenaissance")->getData());
        
                        $utilisateur -> setEmail($form->get("email")->getData());
        
                        $utilisateur -> setPseudo($form->get("pseudo")->getData());

                        // $pp = $utilisateur -> getPhotoDeProfil();
                        // $ext = explode(".", $pp);
                        // $data = explode("uniqid", $ext[0]);
                        // $oldpp = $data[0] + $ext[1];

                        $photodeprofil = $form->get("photodeprofil")->getData();
                        // this condition is needed because the 'photodeprofil' field is not required
                        // so the PDF file must be processed only when a file is uploaded
                        if ($photodeprofil) {
                            $originalFilename = pathinfo($photodeprofil->getClientOriginalName(), PATHINFO_FILENAME);
                            // this is needed to safely include the file name as part of the URL
                            $safeFilename = $slugger->slug($originalFilename);
                            $newFilename = $safeFilename.'-uniqid-'.uniqid().'.'.$photodeprofil->guessExtension();
            
                            // Move the file to the directory where brochures are stored
                            try {
                                $photodeprofil->move(
                                    $this->getParameter('fileDirectory'),//fileDirectory
                                    $newFilename
                                );
                            } catch (FileException $e) {
                                // ... handle exception if something happens during file upload
                            }
            
                            // updates the 'photodeprofilname' property to store the PDF file name
                            // instead of its contents
                            $utilisateur -> setPhotoDeProfil($newFilename);
                        }
        
                        $manager->persist($utilisateur);
                        $manager->flush();
        
                        $contenu = 'le compte à bien été modifié';
                        return $this->redirectToRoute('app_modification_compte', ["id" => $id,"contenu" => $contenu]);
                    }
                    return $this->render('compte/parametres/modification.html.twig', [
                        'form' => $form,
                        'message' => $message
                    ]);
                }

            /* SUPPRESSION COMPTE */

                #[Route('/compte/parametres/suppression/{id}', name: 'app_suppression_compte')]
                public function suppressionCompte($id, ManagerRegistry $doctrine): Response
                {
                    $contenu = 'le compte a bien été supprimé';
                    
                    $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('id' => $id));
                    
                    $manager =$doctrine->getManager();
                    $this->container->get('security.token_storage')->setToken(null);
                    $manager->remove($utilisateur);
                    $manager->flush();

                    return $this->redirectToRoute('app_home', compact(['contenu']));
                }
}
