<?php

namespace App\Controller;

use App\Entity\Preference;
use App\Entity\Site;
use App\Form\AjoutSiteFormType;
use App\Form\PreferenceFormType;
use App\Form\RechercheSiteFormType;
use App\Repository\SiteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
        
    /* RECHERCHE SITE */
    
        #[Route('/site/rechercher/{contenu?}', name: 'app_site_rechercher')]
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

            $liste = $doctrine->getRepository(Site::class)->findAll();
            $preferences = $doctrine->getRepository(Preference::class)->findOneBy(array('utilisateurpref' => $this->getUser()));

            $form = $this->createForm(PreferenceFormType::class, $preferences,[
                'action' => $this->generateUrl('app_site_rechercher'),
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

            return $this->render('site/liste.html.twig', [
                'liste' => $liste,
                'preferences' => $preferences,
                'form' => $form,
                'message' => $message
            ]);
        }

    /* ITEM SITE */

        #[Route('/site/item/{id}', name: 'app_site_item')]
        public function Site($id, ManagerRegistry $doctrine, Request $request): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            $route = $request->headers->get('referer');
            $site = $doctrine->getRepository(Site::class)->findOneBy(array('id' => $id));
            
            return $this->render('site/site.html.twig', [
                'site' => $site,
                'route' => $route,
                'message' => $message
            ]);
        }

    /* LIMITE ITEM SITE */

        #[Route('/site/limiteitem/{id}', name: 'app_site_limiteitem')]
        public function limiteSite($id, ManagerRegistry $doctrine, Request $request): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            $route = $request->headers->get('referer');

            $limitesite = [
                'id' => $id,
                'timer' => 1
            ];
            $site = $doctrine->getRepository(Site::class)->findOneBy($limitesite);
            
            return $this->render('site/site.html.twig', [
                'site' => $site,
                'route' => $route,
                'message' => $message
            ]);
        }
}
