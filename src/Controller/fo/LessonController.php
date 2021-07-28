<?php

namespace App\Controller\fo;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use App\Repository\SubjectRepository;
use App\Repository\ClassSchoolRepository;
use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class LessonController extends AbstractController
{
    /**
     * @Route("/lesson/{lessonslug}", name="fo_lesson")
     */
    public function index(LessonRepository $lessonRepository , ClassSchoolRepository $classSchoolRepository , 
    SubjectRepository $subjectRepository , Request $request): Response
    {
        $routeParams                    = $request->attributes->get('_route_params');
        $slug         = $routeParams['lessonslug']; 
        // dd($slug);
        // $_SESSION['lessonSlug']         = $routeParams['lessonslug']; 
        $classToFind        = $classSchoolRepository->findBy(['slug' => $this->getUser()->getFirstName() ]) ;

        $subject            = $subjectRepository->findBy(['slug' => $slug ]) ;
        $_SESSION['subject'] = $subject ;

        $lessonPerChapter   = $lessonRepository->findLessonPerChapter($_SESSION['subject']) ;
        // dd($lessonPerChapter) ;

        $_SESSION['lessonPerChapter'] = $lessonPerChapter ;

        $lessons            = $lessonRepository->findBy(['status' => 1 , 'classschool' => $classToFind , 'subject' => $_SESSION['subject'] ]) ;
        
        $lessonDetails      = $lessonRepository->findBy(['status' => 1 , 'classschool' => $classToFind ,'slug'=>$slug ]) ;     
        // dd($lessonDetails) ;
        return $this->render('fo/lesson/index.html.twig', [
            'controller_name'   => 'LessonController',
            'lessonPerChapters' => $_SESSION['lessonPerChapter'],
            'lessons'           => $lessons,
            'lessonDetails'     => $lessonDetails,
            // 'lessonSlug'        => $_SESSION['lessonSlug']
        ]);
    }

    /**
     * @Route("/lesson/{lessonslug}/{lessonslugdetail}", name="fo_lesson_detail")
     */
    public function detail(LessonRepository $lessonRepository , ClassSchoolRepository $classSchoolRepository , 
    SubjectRepository $subjectRepository , Request $request): Response
    {
        $routeParams        = $request->attributes->get('_route_params');
        $slug               = $routeParams['lessonslug']; 
        $lessonslugdetail   = $routeParams['lessonslugdetail']; 

        // $_SESSION['lessonSlug']         = $routeParams['lessonslug']; 
        $classToFind        = $classSchoolRepository->findBy(['slug' => $this->getUser()->getFirstName() ]) ;

        $subject            = $subjectRepository->findBy(['slug' => $slug ]) ;
        $_SESSION['subject'] = $subject ;

        $lessonPerChapter   = $lessonRepository->findLessonPerChapter($_SESSION['subject']) ;
        // dd($lessonPerChapter) ;

        $_SESSION['lessonPerChapter'] = $lessonPerChapter ;

        $lessons            = $lessonRepository->findBy(['status' => 1 , 'classschool' => $classToFind , 'subject' => $_SESSION['subject'] ]) ;
        
        $lessonDetails      = $lessonRepository->findBy(['status' => 1 , 'classschool' => $classToFind ,'slug'=>$lessonslugdetail ]) ;     
        // dd($lessonDetails) ;
        return $this->render('fo/lesson/lessonDetails.html.twig', [
            'controller_name'   => 'LessonController',
            'lessonPerChapters' => $_SESSION['lessonPerChapter'],
            'lessons'           => $lessons,
            'lessonDetails'     => $lessonDetails,
            // 'lessonSlug'        => $_SESSION['lessonSlug']
        ]);
    }

    // /**
    //  * @Route("/lesson/sidelist/{slug}" , name="fo_lesson_sidelist")
    //  */
    // public function getSideListLesson(LessonRepository $lessonRepository , ClassSchoolRepository $classSchoolRepository , 
    // SubjectRepository $subjectRepository , Request $request){
    //     $routeParams                    = $request->attributes->get('_route_params');
    //     $lessonSlug                     = $routeParams['slug']; 
    //     // $chapterSlug        = $routeParams['chapterslug']; 

    //     $classToFind        = $classSchoolRepository->findBy(['slug' => $this->getUser()->getFirstName() ]) ;

    //     $subject            = $subjectRepository->findBy(['slug' => $lessonSlug]) ;
    //     // dd($lessonSlug) ;
    //     $lessonPerChapter   = $lessonRepository->findLessonPerChapter($subject) ;
    //     $_SESSION['lessonPerChapter'] = $lessonPerChapter ;
    //     $lessons            = $lessonRepository->findBy(['status' => 1 , 'classschool' => $classToFind , 'subject' => $subject  ]) ;
        
    //     dump($lessonPerChapter);
    //     return $this->render('fo/lesson/sideList.html.twig', [
    //         'controller_name'   => 'LessonController',
    //         'lessonPerChapters' => $lessonPerChapter,
    //         'lessons'           => $lessons,
    //         'lessonSlug'        => $lessonSlug
    //     ]);
    // }

     /**
     * @Route("/lesson/detail/{lessonslug}", name="fo_detail_lesson")
     */
    public function lessonDetail(LessonRepository $lessonRepository , ClassSchoolRepository $classSchoolRepository , 
    SubjectRepository $subjectRepository , Request $request){
        return $this->render('fo/lesson/lessonDetail.html.twig', [
            'controller_name'   => 'LessonController',
        ]); 
    }

    /**
     * @Route("/download/{lessonslug}/{file}", name="generate.lesson.file")
     */
    public function generateFile($lessonslug, $file , LessonRepository $lessonRepository , ClassSchoolRepository $classSchoolRepository ,
    DocumentRepository $documentRepository){

        $classToFind        = $classSchoolRepository->findBy(['slug' => $this->getUser()->getFirstName() ]) ;

        $lessonDetails      = $lessonRepository->findBy(['status' => 1 , 'classschool' => $classToFind ,'slug'=>$lessonslug ]) ;

        $fileDoc            = $documentRepository->findBy(["file"=> $file,"Lesson"=> $lessonDetails]);


        $path = $this->getParameter('document_lesson');
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
