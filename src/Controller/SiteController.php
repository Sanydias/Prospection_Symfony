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

            $listeinput = $doctrine->getRepository(Site::class)->findAll();
                
            $site = new Site();
            $form = $this->createForm(RechercheSiteFormType::class, $site,[
                'action' => $this->generateUrl('app_site_rechercher'),
                'method' => 'POST',
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $inputrecherche = $request->getPayload()->get("rechercher");
                $departement = $request->getPayload()->get("departement");
                $commune = $request->getPayload()->get('commune');
                $lieuxdit = $request->getPayload()->get('lieuxdit');
                $interethistorique = $request->getPayload()->get('interethistorique');
                $timer = $form->get('timer')->getData();
                $recherche = [];
                $liste = [];
                if ($inputrecherche) {
                    // $recherche["interethistorique"] = $inputrecherche;
                    // $order = ["interethistorique" => 'ASC'];
                    // $liste[] = $doctrine->getRepository(Site::class)->findBy($recherche, $order);
                    $explodedrecherche = explode(" ", $inputrecherche);
                    $countrecherche = count($explodedrecherche);
                    for ($i=0; $i < $countrecherche; $i++) { 
                        $recherche[$i] = $explodedrecherche[$i];
                        $liste = $siteRepository->findBySearch($explodedrecherche[$i]);
                    }
                    // $type = [
                    //     "departement",
                    //     "commune",
                    //     "lieuxdit",
                    //     "interethistorique"
                    // ];
                    // $typelength = count($type);
                    // for ($i=0; $i < $typelength; $i++) {
                    //     $recherche[$type[$i]] = $inputrecherche;
                    //     $order = [$type[$i] => 'ASC'];
                    //     $test = $doctrine->getRepository(Site::class)->findBy($recherche, $order);
                    //     array_push($liste, $test);
                    // }
                    // $test = $liste[0];
                    // $message = implode(" ", $test);
                } else {
                    if ($departement) {
                        $recherche["departement"] = $departement;
                        $order = ['departement' => 'ASC'];
                    }
                    if ($commune) {
                        $recherche["commune"] = $commune;
                        $order = ['commune' => 'ASC'];
                    }
                    if ($lieuxdit) {
                        $recherche["lieuxdit"] = $lieuxdit;
                        $order = ['lieuxdit' => 'ASC'];
                    }
                    if ($interethistorique) {
                        $recherche["interethistorique"] = $interethistorique;
                        $order = ['interethistorique' => 'ASC'];
                    }
                    if ($timer) {
                        $recherche["timer"] = $timer;
                        // $recherche["tempsrestant"] = ;
                        $order = ['tempsrestant' => 'ASC'];
                    }
                    if ($recherche) {
                        $liste = $doctrine->getRepository(Site::class)->findBy($recherche, $order);
                    }else {
                        $order= ['timer' => 'ASC'];
                        $liste = $doctrine->getRepository(Site::class)->findAll(array(), $order);
                    }
                }
                return $this->render('site/liste.html.twig', [
                    'form' => $form,
                    'listeinput' => $listeinput,
                    'liste' => $liste,
                    'resultat' => $recherche,
                    'submitted' => true,
                    'message' => $message
                ]);
            }else{
                return $this->render('site/liste.html.twig', [
                    'form' => $form,
                    'listeinput' => $listeinput,
                    'submitted' => false,
                    'message' => $message
                ]);
            }
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
