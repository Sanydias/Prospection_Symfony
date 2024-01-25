<?php

namespace App\Controller;

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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{

    /* INSCRIPTION */

        #[Route('/inscription/{message?}', name: 'app_inscription')]
        public function inscription($message, ManagerRegistry $doctrine, SluggerInterface $slugger, UserPasswordHasherInterface $hash, Request $request): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = '';
                        $display = "none";
                }

            $manager = $doctrine->getManager();
            $utilisateur = new Utilisateur($request);
    
            $form = $this->createForm(UtilisateurFormType::class, $utilisateur,[
                'action' => $this->generateUrl('app_inscription'),
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

                $utilisateur -> setPassword($hash->hashPassword($utilisateur, $form->get("password")->getData()));

                $utilisateur -> setPseudo($form->get("pseudo")->getData());

                $photodeprofil = $form->get("photodeprofil")->getData();
                // this condition is needed because the 'photodeprofil' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($photodeprofil) {
                    $originalFilename = pathinfo($photodeprofil->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$photodeprofil->guessExtension();
    
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

                $message = "L'utilisateur a bien été créé";
                return $this->redirectToRoute('app_connexion', ["message" => $message]);
            }else{
                //$liste = $doctrine->getRepository(Utilisateur::class)->findBy(['email' => $email]);
                $message = "Attention, ce mail a déjà été attribué !";
            }

            return $this->render('security/inscription.html.twig', [
                'display' => $display,
                'message' => $message,
                'form' => $form,
            ]);
        }

    /* CONNEXION */

        #[Route(path: '/connexion/{message?}', name: 'app_connexion')]
        public function login($message, AuthenticationUtils $authenticationUtils): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = 'none';
                        $display = "none";
                }

            // if ($this->getUser()) {
            //     return $this->redirectToRoute('target_path');
            // }

            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/connexion.html.twig', [
                'display' => $display,
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
        
}
