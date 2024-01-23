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

class HomeController extends AbstractController
{

    /* HOME */

        #[Route('/home/{message?}', name: 'app_home')]
        public function afficherPage($message): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                if (isset($message)) {
                    $display = "flex";
                }else{
                        $message = '';
                        $display = "none";
                }

            return $this->render("home/index.html.twig", [
                'display' => $display,
                'message' => $message
            ]);
        }

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

            return $this->render('compte/inscription.html.twig', [
                'display' => $display,
                'message' => $message,
                'form' => $form,
            ]);
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
