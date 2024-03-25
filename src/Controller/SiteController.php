<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\AjoutSiteFormType;
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
    
        #[Route('/site/rechercher', name: 'app_site_rechercher')]
        public function index(ManagerRegistry $doctrine, Request $request, SiteRepository $siteRepository): Response
        {
            $message = [
                'display' => 'none',
                'contenu' => 'none',
                'bouton' => FALSE,
                'lien' => 'none'
            ];

            $liste = $doctrine->getRepository(Site::class)->findAll();

            return $this->render('site/liste.html.twig', [
                'liste' => $liste,
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
