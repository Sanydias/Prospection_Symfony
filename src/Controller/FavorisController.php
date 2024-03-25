<?php

namespace App\Controller;

use App\Entity\Favori;
use App\Entity\Site;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavorisController extends AbstractController
{
    /* AJOUTER FAVORI */

        #[Route('/favori/ajouter/{id}', name: 'app_favori_ajouter')]
        public function ajouterFavori($id, ManagerRegistry $doctrine, Request $request): Response
        {
            
            $route = $request->headers->get('referer');

            $manager = $doctrine->getManager();
            
            $autrefavori = $doctrine->getRepository(Favori::class)->findBy(['utilisateur' => $this->getUser()]);
            if ($autrefavori) {
                $tempvar = 0;
                for ($i=0; $i < count($autrefavori); $i++) {
                    $value = $autrefavori[$i];
                    $getranking = $value->getRanking();
                    if ($getranking > $tempvar) {
                        $tempvar = $getranking;
                    }
                }
                $ranking = $tempvar + 1;
            } else {
                $ranking = 1;
            }
            $site = $doctrine->getRepository(Site::class)->findOneBy(['id' => $id]);
            $favori = new Favori();
            $favori->setUtilisateur($this->getUser());
            $favori->setSite($site);
            $favori->setRanking($ranking);
            $manager->persist($favori);
            $manager->flush();
            
            return $this->redirect($route);
        }

    /* MODIFIER FAVORI */

        #[Route('/favori/modifier/{id}', name: 'app_favori_modifier')]
        public function modifierFavori($id, ManagerRegistry $doctrine, Request $request): Response
        {
            $route = $request->headers->get('referer');
            $manager = $doctrine->getManager();

            $elements = explode("-", $id);
            for ($i=0; $i < count($elements); $i++) { 
                $valeursElements = explode("_", $elements[$i]);
                $idElement = $valeursElements[0];
                $favori = $doctrine->getRepository(Favori::class)->findOneBy(['id' => $idElement]);
                $favori->setRanking($i+1);
                $manager->persist($favori);
                $manager->flush();
            }
            
            return $this->redirect($route);
        }

    /* SUPPRIMER FAVORI */

        #[Route('/favori/supprimer/{id}', name: 'app_favori_supprimer')]
        public function supprimerFavori($id, ManagerRegistry $doctrine, Request $request): Response
        {
            
            $route = $request->headers->get('referer');

            $manager = $doctrine->getManager();
            
            $favori = $doctrine->getRepository(Favori::class)->findOneBy(['utilisateur' => $this->getUser(), 'site' => $id]);
            $manager->remove($favori);
            $manager->flush();
            
            return $this->redirect($route);
        }
}
