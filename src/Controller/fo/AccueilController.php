<?php

namespace App\Controller\fo;

use App\Repository\HomeGalleryRepository;
use App\Repository\HomePresentationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="fo_accueil")
     */
    public function index(HomeGalleryRepository $homeGalleryRepository , HomePresentationRepository $homePresentationRepository): Response
    {
        $homegalleryLists       = $homeGalleryRepository->findAll() ;
        $homePresentationLists  = $homePresentationRepository->findBy(['status' => true]) ;
        return $this->render('fo/accueil/index.html.twig', [
            'controller_name'           => 'AccueilController',
            'homegalleryLists'          => $homegalleryLists,
            'homePresentationLists'     => $homePresentationLists,
        ]);
    }
}
