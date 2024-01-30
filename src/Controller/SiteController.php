<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    #[Route('/site/rechercher', name: 'app_site')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $message = '';
        $display = "none";
                    
        $manager = $doctrine->getManager();
        $site = new Site();
        $form = $this->createForm(SiteFormType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($site);
            $manager->flush();
            return $this->redirectToRoute('app_site_add');
        }
        
        return $this->render('site/index.html.twig', [
            'form' => $form->createView(),
            'display' => $display,
            'message' => $message
        ]);
    }

    #[Route('/site/add/{message?}', name: 'app_site_add')]
    public function addSite($message, ManagerRegistry $doctrine, Request $request): Response
    {

        /* RECUPÉRATION D'UN MESSAGE SI EXISTANT */
        
            if (isset($message)) {
                $display = "flex";
            }else{
                    $message = '';
                    $display = "none";
            }
                    
        $manager = $doctrine->getManager();
        $site = new Site();
        $form = $this->createForm(SiteFormType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($site);
            $manager->flush();
            return $this->redirectToRoute('app_site');
        }
        
        return $this->render('site/add.html.twig', [
            'f' => $form->createView(),
            'display' => $display,
            'message' => $message
        ]);
    }
}
