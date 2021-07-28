<?php

namespace App\Controller\admin;

use App\Entity\ClassSchool ;
use App\Form\ClassType ;
use App\Repository\ClassSchoolRepository ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Route("/admin/student")
 */
class StudentController extends AbstractController
{
	protected $em ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }

    /**
     * @Route("/class", name="bo_student_class")
     */
    public function index( Request $request , ClassSchoolRepository $classSchoolRepository): Response
    {
        $listClass = $classSchoolRepository->findAll() ;
        return $this->render('admin/student/index.html.twig', [
            'controller_name' => 'StudentController',
            'listClass'       => $listClass
        ]);
    }

    /**
     * @Route("/class/add", name="bo_student_class_add")
     * @Route("/class/edit/{id}", name="bo_student_class_edit")
     */
    public function addStudent(ClassSchool $classSchool=null , Request $request , ClassSchoolRepository $classSchoolRepository ): Response
    {
       
        if (!$classSchool) {
            $classSchool = new ClassSchool() ; 
        }
        $form = $this->createForm(ClassType::class , $classSchool) ;

        if ($classSchool->getId() !=null ) {
            $routeParams    = $request->attributes->get('_route_params');
            $id             = $routeParams['id']; 
            $classEdit      = $classSchoolRepository->findById($id) ;
        }
        else{
            $classEdit      = null ;
        }

        $form->handleRequest($request) ; 
        if ($form->isSubmitted() && $form->isValid()) {
            $classSchool->setSlug($form->get('user')->getData()->getFirstname()) ;
            $classSchool->setName($form->get('user')->getData()->getFirstname()) ;
            $this->em->persist($classSchool) ;
            $this->em->flush() ;

            return $this->redirectToRoute('bo_student_class');
        }

        return $this->render('admin/student/newClass.html.twig', [
            'controller_name'   => 'StudentController',
            'form_class'        => $form->createView() , 
            'editMode'          => $classSchool->getId() !=null ,
            'classEdit'         => $classEdit ,
        ]);
    }

    /**
     * @Route("/class/delete/{id}" ,name="bo_class_delete")
     */
    public function deleteStudent(ClassSchool $classSchool , Request $request , ClassSchoolRepository $classSchoolRepository , $id ){
        $classDelete = $classSchoolRepository->findById($id) ;

        $this->em->remove($classSchool);
        $this->em->flush();

        return $this->redirectToRoute("bo_student_class");
    }

}
