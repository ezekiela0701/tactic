<?php

namespace App\Controller\admin;

use App\Entity\HomeGallery;
use App\Entity\HomePresentation;
use App\Form\HomeGalleryType;
use App\Form\HomePresentationType;
use App\Repository\HomeGalleryRepository;
use App\Repository\HomePresentationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin")
*/
class HomeController extends AbstractController
{
    protected $em ;
    protected $serializer ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }

    /**
     * @Route("/presentation/list", name="bo_presentation_List")
     */
    public function presentationList(HomePresentationRepository $homePresentationRepository): Response
    {
        $hommePresentationLists = $homePresentationRepository->findAll() ;
        return $this->render('admin/home/presentationList.html.twig', [
            'controller_name'           => 'HomeController',
            'hommePresentationLists'    => $hommePresentationLists,
        ]);
    }

    /**
     * @Route("/presentation/add", name="bo_presentation_add")
     * @Route("/presentation/edit/{id}", name="bo_presentation_edit")
     */
    public function presentationAdd(Request $request , HomePresentation $homePresentation = null , 
    HomePresentationRepository $homePresentationRepository): Response
    {
        if(!$homePresentation){
            $homePresentation = new HomePresentation() ;
            $hommePresentationLists = $homePresentationRepository->findAll() ;
            $svg = $this->traitementSvg(count($hommePresentationLists)) ;
        }

        $form = $this->createForm(HomePresentationType::class , $homePresentation) ;

        $form->handleRequest($request) ; 

        // dd($hommePresentationLists) ;

        if ($form->isSubmitted() && $form->isValid()) {
            if($homePresentation->getId() != null ){
                
            }else{
                $homePresentation->setSvg($svg);
            }
            // dd('ivelany') ;
            $this->em->persist($homePresentation);
                    
            $this->em->flush() ;
        
            return $this->redirectToRoute('bo_presentation_List') ;
        }

        return $this->render('admin/home/presentationAdd.html.twig', [
            'controller_name'   => 'HomeController',
            'editMode'          => $homePresentation->getId() != null ,
            'formPresentation'  => $form->createView() , 
        ]);
    }

    /**
     * @Route("/galery/list", name="bo_galery_List")
     */
    public function galleryList(HomeGalleryRepository $homeGalleryRepository): Response
    {
        $hommeGalleryLists = $homeGalleryRepository->findAll() ;
        return $this->render('admin/home/galleryList.html.twig', [
            'controller_name'   => 'HomeController',
            'hommeGalleryLists' => $hommeGalleryLists,
        ]);
    }

     /**
     * @Route("/galery/add", name="bo_galery_add")
     * @Route("/galery/edit/{id}", name="bo_galery_edit")
     */
    public function galleryAdd(Request $request , HomeGallery $homeGallery=null): Response
    {
        if (!$homeGallery) {
            $homeGallery = new HomeGallery() ; 
        }
        $form = $this->createForm(HomeGalleryType::class , $homeGallery) ;

        $form->handleRequest($request) ; 
        if ($form->isSubmitted() && $form->isValid()) {
            $images =$form->get('file')->getData() ;
            if($images){
                for($i=0; $i<count($images); $i++){
                    $filedoc = explode('.',$images[$i]->getClientOriginalName());
                    $filenamedoc = $filedoc[0].'.'.$images[$i]->guessExtension();

                    $homeGallery->setFile($filenamedoc);
                    $homeGallery->setCreated(new \DateTime());

                    $this->em->persist($homeGallery);

                    $images[$i]->move($this->getParameter('img_gallery_accueil'), $filenamedoc);
                }
                $this->em->flush() ;
            }
            return $this->redirectToRoute('bo_galery_List') ;
        }

        return $this->render('admin/home/galleryAdd.html.twig', [
            'controller_name' => 'HomeController',
            'formGallery'     => $form->createView() , 
            'homeGallery'     => $homeGallery , 
            'editMode'        => $homeGallery->getId() != null , 
        ]);
    }

    public function traitementSvg($total){
        $resultSvg = 1 ;

        $totalTrait = floatval($total/4) ; 
        $result = explode('.',strval($totalTrait) , 2) ;
        if(isset($result[1])){
            if($result[1] == "25"){
                $resultSvg = 1 ;
            }elseif($result[1] == "5"){
                $resultSvg = 2 ;
            }elseif($result[1] == "75"){
                $resultSvg = 3 ;
            }
        }
        else{
            $resultSvg = 4 ;
        }

        return $resultSvg ;
    }
}
