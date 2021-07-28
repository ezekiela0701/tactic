<?php

namespace App\Controller\admin;

use App\Entity\Carousel;
use App\Form\CarouselType;
use App\Repository\CarouselRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/carousel")
*/
class CarouselController extends AbstractController
{
    protected $em ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }
    /**
     * @Route("/", name="bo_carousel")
     */
    public function index(CarouselRepository $carouselRepository): Response
    {
        $listeCarousels = $carouselRepository->findAll() ;
        return $this->render('admin/carousel/index.html.twig', [
            'controller_name' => 'CarouselController',
            'listeCarousels'  => $listeCarousels,
        ]);
    }
    /**
     * @Route("/add", name="bo_carousel_add")
     * @Route("/edit/{id}", name="bo_carousel_edit")
     */
    public function addCarousel(Carousel $carousel=null , CarouselRepository $carouselRepository ,
    Request $request): Response
    {
        if(!$carousel){
            $carousel = new Carousel() ;
        }
        $form = $this->createForm(CarouselType::class , $carousel) ;
        $form->handleRequest($request) ; 
        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('image')->getData() ;
            if($files){
                for($i=0; $i<count($files); $i++){
                    $filedoc = explode('.',$files[$i]->getClientOriginalName());
                    $filenamedoc = $filedoc[0].'.'.$files[$i]->guessExtension();
                    $carousel->setImage($filenamedoc) ;
                    $files[$i]->move($this->getParameter('img_carousel'), $filenamedoc);
                }
            }
            $this->em->persist($carousel) ;
            $this->em->flush() ;



            return $this->redirectToRoute('bo_carousel');
        }
        return $this->render('admin/carousel/add.html.twig', [
            'controller_name' => 'CarouselController',
            'formCarousel'    => $form->createView() ,
            'editMode'        => $carousel->getId() != null ,
            'carousel'        => $carousel ,  
        ]);
    }
}
