<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\OubliFormType;
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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    /* INSCRIPTION */

        #[Route('/inscription/{contenu?}', name: 'app_inscription')]
        public function inscription($contenu, ManagerRegistry $doctrine, SluggerInterface $slugger, UserPasswordHasherInterface $hash, Request $request): Response
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

            $manager = $doctrine->getManager();
            $utilisateur = new Utilisateur($request);
    
            $form = $this->createForm(UtilisateurFormType::class, $utilisateur,[
                'action' => $this->generateUrl('app_inscription'),
                'method' => 'POST',
            ]);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $liste = $doctrine->getRepository(Utilisateur::class)->findBy(['email' => $form->get("email")->getData()]);
                if ($liste) {
                    $message = "Attention, ce mail a déjà été attribué !";
                } else {
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

                    $utilisateur -> setPassword($hash->hashPassword($utilisateur, $form->get("password")->getData()));

                    $utilisateur -> setPseudo($form->get("pseudo")->getData());

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
                    $utilisateur -> setRoles(['ROLE_USER']);
                    $utilisateur -> setDateDeCreationDuCompte(new DateTimeImmutable());

                    $manager->persist($utilisateur);
                    $manager->flush();

                    return $this->redirectToRoute('app_connexion');
                }
            }

            return $this->render('security/inscription.html.twig', [
                'message' => $message,
                'form' => $form,
            ]);
        }

    /* CONNEXION */

        #[Route(path: '/connexion', name: 'app_connexion')]
        public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
        {
            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
            
                $route = $request->headers->get('referer');
                if( $route == "https://127.0.0.1:8000/inscription"){
                    $message = [
                        'display' => 'flex',
                        'contenu' => "l'utilisateur a été bien ajouté",
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

            // if ($this->getUser()) {
            //     return $this->redirectToRoute('target_path');
            // }

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/connexion.html.twig', [
                'message' => $message,
                'last_username' => $lastUsername,
                'error' => $error
            ]);
        }

    /* DÉCONNEXION */

        #[Route(path: '/deconnexion', name: 'app_deconnexion')]
        public function logout(): void
        {
            throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        }

    /* OUBLI DE MOT DE PASSE */

        #[Route('/oubli/{contenu?}', name: 'app_oubli')]
        public function oubli($contenu, ManagerRegistry $doctrine, UserPasswordHasherInterface $hash, Request $request): Response
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

            $manager = $doctrine->getManager();
            $getutilisateur = new Utilisateur($request);
    
            $form = $this->createForm(OubliFormType::class, $getutilisateur,[
                'action' => $this->generateUrl('app_oubli'),
                'method' => 'POST',
            ]);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $utilisateur = $doctrine->getRepository(Utilisateur::class)->findOneBy(array('email' => $form->get("email")->getData()));
                $utilisateur -> setPassword($hash->hashPassword($utilisateur, $form->get("password")->getData()));

                $manager->persist($utilisateur);
                $manager->flush();
                $contenu = "le mot de passe a bien été modifié";
                
                return $this->redirectToRoute('app_connexion', ["contenu" => $contenu]);
            }

            return $this->render('security/oubli.html.twig', [
                'message' => $message,
                'form' => $form
            ]);
        }
        
}
