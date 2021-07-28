<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Subject ;
use App\Form\SubjectType ;
use App\Repository\SubjectRepository ;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


/**
* @Route("/admin")
*/
class SubjectController extends AbstractController
{
    protected $em ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }
    /**
     * @Route("/subject", name="bo_subject")
     */
    public function index(SubjectRepository $subjectRepository): Response
    {
        $listSubjects = $subjectRepository->findAll() ;
        return $this->render('admin/subject/index.html.twig', [
            'controller_name' => 'SubjectController',
            'listSubjects' => $listSubjects,
        ]);
    }

    /**
     * @Route("/subject/add", name="bo_subject_add")
     * @Route("/subject/edit/{id}", name="bo_subject_edit")
     */
    public function addSubject(Subject $subject=null , Request $request , SubjectRepository $subjectRepository ): Response
    {
       
        if (!$subject) {
            $subject = new Subject() ; 
        }
        $form = $this->createForm(SubjectType::class , $subject) ;

        if ($subject->getId() !=null ) {
            $routeParams    = $request->attributes->get('_route_params');
            $id             = $routeParams['id']; 
            $subjectEdit    = $subjectRepository->findById($id) ;
        }
        else{
            $subjectEdit   = null ;
        }

        $form->handleRequest($request) ; 
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $form->get('name')->getData() ;
            $subject->setSlug($form->get('name')->getData()) ;
            $this->em->persist($subject) ;
            $this->em->flush() ;

            return $this->redirectToRoute('bo_subject');
        }

        return $this->render('admin/subject/newSubject.html.twig', [
            'controller_name'   => 'StudentController',
            'form_subject'     => $form->createView() , 
            'editMode'          => $subject->getId() !=null ,
            'subjectEdit'      => $subjectEdit ,
        ]);
    }
}
