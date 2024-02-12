<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\AjoutSiteFormType;
use App\Form\RechercheSiteFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
        
    /* RECHERCHE SITE */
    
        #[Route('/site/rechercher/{message?}', name: 'app_site_rechercher')]
        public function index($message, ManagerRegistry $doctrine, Request $request): Response
        {

            /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */

                if (isset($message)) {
                    $display = "flex";
                }else{
                    $message = 'none';
                    $display = "none";
                }

            $listeinput = $doctrine->getRepository(Site::class)->findAll();
                
            $site = new Site();
            $form = $this->createForm(RechercheSiteFormType::class, $site,[
                'action' => $this->generateUrl('app_site_rechercher'),
                'method' => 'POST',
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $departement = $request->getPayload()->get("departement");
                $commune = $request->getPayload()->get('commune');
                $lieuxdit = $request->getPayload()->get('lieuxdit');
                $interethistorique = $request->getPayload()->get('interethistorique');
                $timer = $form->get('timer')->getData();
                $recherche = [];
                if ($departement) {
                    $recherche["departement"] = $departement;
                    $order= ['departement' => 'ASC'];
                }
                if ($commune) {
                    $recherche["commune"] = $commune;
                    $order= ['commune' => 'ASC'];
                }
                if ($lieuxdit) {
                    $recherche["lieuxdit"] = $lieuxdit;
                    $order= ['lieuxdit' => 'ASC'];
                }
                if ($interethistorique) {
                    $recherche["interethistorique"] = $interethistorique;
                    $order= ['interethistorique' => 'ASC'];
                }
                if ($timer) {
                    $recherche["timer"] = $timer;
                    // $recherche["tempsrestant"] = ;
                    $order= ['tempsrestant' => 'ASC'];
                }
                if ($recherche) {
                    $liste = $doctrine->getRepository(Site::class)->findBy($recherche, $order);
                }else {
                    $order= ['timer' => 'ASC'];
                    $liste = $doctrine->getRepository(Site::class)->findAll(array(), $order);
                }
                return $this->render('site/liste.html.twig', [
                    'form' => $form,
                    'listeinput' => $listeinput,
                    'liste' => $liste,
                    'resultat' => $recherche,
                    'submitted' => true,
                    'display' => $display,
                    'message' => $message
                ]);
            }else{
                return $this->render('site/liste.html.twig', [
                    'form' => $form,
                    'listeinput' => $listeinput,
                    'submitted' => false,
                    'display' => $display,
                    'message' => $message
                ]);
            }
        }

    /* ITEM SITE */

        #[Route('/site/item/{id}', name: 'app_site_item')]
        public function addSite($id, ManagerRegistry $doctrine, Request $request): Response
        {
            $message = '';
            $display = "none";

            $site = $doctrine->getRepository(Site::class)->findOneBy(array('id' => $id));
            
            return $this->render('site/site.html.twig', [
                'site' => $site,
                'display' => $display,
                'message' => $message
            ]);
        }
}
