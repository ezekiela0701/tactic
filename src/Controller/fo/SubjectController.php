<?php

namespace App\Controller\fo;

use App\Repository\ClassSchoolRepository;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/student")
*/
class SubjectController extends AbstractController
{
    /**
     * @Route("/subject", name="subject_fo")
     */
    public function index(SubjectRepository $subjectRepository , ClassSchoolRepository $classSchoolRepository): Response
    {
        $classToFind    = $classSchoolRepository->findBy(['slug' =>$this->getUser()->getFirstName() ]) ;
        $listSubjects = $subjectRepository->findBy(['status' => 1 , 'classschool' => $classToFind]) ;
        return $this->render('fo/subject/index.html.twig', [
            'controller_name'   => 'SubjectController',
            'listSubjects'      => $listSubjects ,
        ]);
    }
}
