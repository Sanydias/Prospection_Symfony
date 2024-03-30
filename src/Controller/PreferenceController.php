<?php

namespace App\Controller;

use App\Entity\Preference;
use App\Entity\Site;
use App\Entity\Utilisateur;
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
            
            $preferences = $doctrine->getRepository(Preference::class)->findOneBy(array('utilisateurpref' => $this->getUser()));
            if ($preferences) {
                $preference = $preferences;
            } else {
                $preference = new Preference();
            }
            $form = $this->createForm(PreferenceFormType::class, $preference,[
                'action' => $this->generateUrl('app_preference'),
                'method' => 'POST'
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $departement = $request->getPayload()->get("departement");
                if ($departement == '') {
                    $departement = 'NONE';
                }
                $commune = $request->getPayload()->get("commune");
                if ($commune == '') {
                    $commune = 'NONE';
                }
                $lieuxdit = $request->getPayload()->get("lieuxdit");
                if ($lieuxdit == '') {
                    $lieuxdit = 'NONE';
                }
                $interethistorique = $request->getPayload()->get("interethistorique");
                if ($interethistorique == '') {
                    $interethistorique = 'NONE';
                }
                $timer = $request->getPayload()->get("limite");
                if ($timer == 0) {
                    $timer = 'NONE';
                }

                return $this->redirectToRoute('app_preference_ajouter', array('departement' => $departement, 'commune' => $commune, 'lieuxdit' => $lieuxdit, 'interethistorique' => $interethistorique, 'timer' => $timer));

            }

        $liste = $doctrine->getRepository(Site::class)->findAll();

        return $this->render('/compte/parametres/preference/index.html.twig', [
            'preferences' => $preferences,
            'form' => $form,
            'liste' => $liste,
            'message' => $message
        ]);
    }

    /* AJOUT / MODIFICATION PRÉFÉRENCE */

        #[Route('/compte/parametres/preference/ajouter/{departement}/{commune}/{lieuxdit}/{interethistorique}/{timer}', name: 'app_preference_ajouter')]
        public function ajouterPreference($departement, $commune, $lieuxdit, $interethistorique, $timer, ManagerRegistry $doctrine, Request $request): Response
        {

            $manager = $doctrine->getManager();

            $getpreference = $doctrine->getRepository(Preference::class)->findOneBy(array('utilisateurpref' => $this->getUser()));
            if ($getpreference) {
                $preference = $getpreference;
            } else {
                $preference = new Preference;
                $preference -> setTypePreference( "departement, commune, lieuxdit, interethistorique, timer");
                $preference -> setUtilisateurpref($this->getUser());
            }
            $preference -> setLieu($departement . ', ' . $commune . ', ' . $lieuxdit . ', ' . $interethistorique . ', ' . $timer);

            
            $route = $request->headers->get('referer');

            $manager->persist($preference);
            $manager->flush();
            return $this->redirect($route);
        }

    /* SUPPRESSION PRÉFÉRENCE */

        #[Route('/compte/parametres/preference/supprimer/{id}', name: 'app_preference_supprimer')]
        public function supprimerPreference($id, ManagerRegistry $doctrine): Response
        {
            $contenu = 'la préférence a bien été supprimé';

            $preference = $doctrine->getRepository(Preference::class)->findOneBy(array('id' => $id));
            
            $manager = $doctrine->getManager();
            $manager->remove($preference);
            $manager->flush();

            return $this->redirectToRoute('app_preference', [
                'contenu' => $contenu
            ]);
        }
}
