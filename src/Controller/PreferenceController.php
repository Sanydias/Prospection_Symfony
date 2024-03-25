<?php

namespace App\Controller;

use App\Entity\Preference;
use App\Form\PreferenceFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PreferenceController extends AbstractController
{
    #[Route('/compte/parametres/preference/{contenu?}', name: 'app_preference')]
    public function index($contenu, ManagerRegistry $doctrine, Request $request): Response
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
            
            $preferences = $doctrine->getRepository(Preference::class)->findOneBy(array('id' => $this->getUser()));
            if ($preferences) {
                # code... modification et suppression
            } else {
                $preference = new Preference();
                $form = $this->createForm(PreferenceFormType::class, $preference,[
                    'action' => $this->generateUrl('app_preference'),
                    'method' => 'POST'
                ]);
    
                $form->handleRequest($request);
    
                if ($form->isSubmitted() && $form->isValid()) {
    
                }
            }


        return $this->render('/compte/parametres/preference/index.html.twig', [
            'preference' => $preferences,
            'form' => $form,
            'message' => $message
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
}
