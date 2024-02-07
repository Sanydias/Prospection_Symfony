<?php

namespace App\Controller;

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

                #[Route('/compte/parametres/modification/{id}/{message?}', name: 'app_modification_compte')]
                public function modificationCompte($id, ManagerRegistry $doctrine, SluggerInterface $slugger, Request $request, $message): Response
                {
                    /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
    
                        if (isset($message)) {
                            $display = "flex";
                        }else{
                                $message = 'none';
                                $display = "none";
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
        
                        $message = "le compte à bien été modifié";
                        $display = "flex";
                        return $this->redirectToRoute('app_modification_compte', ["id" => $id,"message" => $message]);
                    }
                    return $this->render('compte/parametres/modification.html.twig', [
                        'form' => $form,
                        'display' => $display,
                        'message' => $message
                    ]);
                }

            /* SUPPRESSION COMPTE */

                #[Route('/compte/parametres/suppression/{id}', name: 'app_suppression_compte')]
                public function suppressionCompte($id, ManagerRegistry $doctrine): Response
                {
                    
                    $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('id' => $id));

                    $message = "le compte a bien été supprimé";
                    $display = "flex";
                    
                    $manager =$doctrine->getManager();
                    $this->container->get('security.token_storage')->setToken(null);
                    $manager->remove($utilisateur);
                    $manager->flush();

                    return $this->redirectToRoute('app_home', [
                        'display' => $display,
                        'message' => $message
                    ]);
                }
}
