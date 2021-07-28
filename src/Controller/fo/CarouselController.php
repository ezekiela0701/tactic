<?php

namespace App\Controller\fo;

use App\Repository\CarouselRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
* @Route("/student/carousel")
*/
class CarouselController extends AbstractController
{
    /**
     * @Route("/", name="fo_carousel")
     */
    public function index(CarouselRepository $carouselRepository): Response
    {
        $listCarousels = $carouselRepository->findBy(['status' => 1]) ;
        return $this->render('fo/components/carousel.html.twig', [
            'controller_name'   => 'CarouselController',
            'listCarousels'     => $listCarousels,
        ]);
    }
}
