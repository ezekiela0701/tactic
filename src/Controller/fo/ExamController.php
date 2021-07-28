<?php

namespace App\Controller\fo;

use App\Repository\ExamRepository;
use App\Repository\SubjectRepository;
use App\Repository\ClassSchoolRepository;
use App\Repository\DocumentExamRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
* @Route("/student")
*/
class ExamController extends AbstractController
{
    /**
     * @Route("/exam/subject", name="exam_fo")
     */
    public function subjectList(SubjectRepository $subjectRepository , ClassSchoolRepository $classSchoolRepository
    , Request $request , ExamRepository $examRepository): Response
    { 

        $classToFind    = $classSchoolRepository->findBy(['slug' =>$this->getUser()->getFirstName() ]) ;
        $listSubjects = $subjectRepository->findBy(['status' => 1 , 'classschool' => $classToFind]) ;

        // $listSubjects = $subjectRepository->findBy(['status' => 1 , 'classschool' => $classToFind]) ;
        $exams        = $examRepository->findBy(['status' => 1 , 'classSchool' => $classToFind ]) ;
// dd($exams) ;
        return $this->render('fo/exam/index.html.twig', [
            'controller_name'   => 'SubjectController',
            'listSubjects'      => $listSubjects ,
            'exams'             => $exams ,
        ]);
    }

//     /**
//      * @Route("/exam/{examslug}", name="exam_fo_detail")
//      */
//     public function index(ExamRepository $examRepository , ClassSchoolRepository $classSchoolRepository , 
//     SubjectRepository $subjectRepository , Request $request): Response
//     {
//         $routeParams        = $request->attributes->get('_route_params');
//         $examslug           = $routeParams['examslug']; 

//         $classToFind        = $classSchoolRepository->findBy(['slug' => $this->getUser()->getFirstName() ]) ;
//         $listSubjects = $subjectRepository->findBy(['status' => 1 , 'classschool' => $classToFind]) ;

//         // $subject            = $subjectRepository->findBy(['slug' => $examslug]) ;

//         // $lessonPerChapter   = $lessonRepository->findLessonPerChapter($subject) ;

//         // $lessons            = $lessonRepository->findBy(['status' => 1 , 'classschool' => $classToFind , 'subject' => $subject ]) ;
        
//         $exams      = $examRepository->findBy(['status' => 1 , 'classschool' => $classToFind ,'slug'=>$examslug ]) ;     
// // dd($exams) ;
//         return $this->render('fo/exam/index.html.twig', [
//             'controller_name'   => 'LessonController',
//             // 'lessonPerChapters' => $lessonPerChapter,
//             'exams'           => $exams,
//             // 'lessonDetails'     => $lessonDetails,
//         ]);
//         return $this->render('fo/exam/index.html.twig', [
//             'controller_name' => 'ExamController',
//         ]);
//     }
// 
    /**
     * @Route("/download/{examslug}/{file}", name="generate.exam.file")
     */
    public function generateFile($examslug, $file , ExamRepository $examRepository , ClassSchoolRepository $classSchoolRepository ,
    DocumentExamRepository $documentExamRepository , Request $request){
        $routeParams        = $request->attributes->get('_route_params');
        $examslug           = $routeParams['examslug']; 

        $classToFind        = $classSchoolRepository->findBy(['slug' => $this->getUser()->getFirstName() ]) ;

        $examDetails        = $examRepository->findBy(['status' => 1 , 'classSchool' => $classToFind ,'slug'=>$examslug ]) ;

        $fileDoc            = $documentExamRepository->findBy(["file"=> $file,"exam"=> $examDetails]);


        $path = $this->getParameter('document_exam');
        $content = file_get_contents($path . $file);

        $extension = pathinfo($path . $file, PATHINFO_EXTENSION);
        $fileName = $fileDoc[0]->getFile() . "." . $extension;

        $response = new Response();

        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="' . $fileName);

        $response->setContent($content);

        return $response;
    }

}
