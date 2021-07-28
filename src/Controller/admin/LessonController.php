<?php

namespace App\Controller\admin;

use App\Entity\Document;
use App\Entity\Lesson;
use App\Entity\VideosLesson;
use App\Form\LessonType;
use App\Repository\LessonRepository;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ClassSchoolRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin")
*/
class LessonController extends AbstractController
{
    protected $em ;
    protected $serializer ;
    public function __construct(EntityManagerInterface $em , SerializerInterface $serializer)
    {
        $this->em = $em ;
        $this->serializer = $serializer; 
    }
    public function serializeData($data)
    {
        return $this->serializer->serialize($data, 'json');
    }
    /**
     * @Route("/lesson", name="bo_lesson")
     */
    public function index(LessonRepository $lessonRepository): Response
    {
        $lessons = $lessonRepository->findAll() ;
        return $this->render('admin/lesson/index.html.twig', [
            'controller_name'   => 'LessonController',
            'lessons'           => $lessons,
        ]);
    }

     /**
     * @Route("/lesson/create", name="bo_lesson_create")
     */
    public function addLesson(Request $request , Lesson $lesson =null , ClassSchoolRepository $classSchoolRepository ,
    SubjectRepository $subjectRepository): Response
    {
        if (!$lesson) {
            $lesson = new Lesson() ;
        }
        $classSchoolLists = $classSchoolRepository->findBy(['status' => 1]) ;

        $form = $this->createForm(LessonType::class , $lesson ) ;
        
        $form->handleRequest($request) ;
        
        if($form->isSubmitted() && $form->isValid()){
            $class      = $request->request->get('class') ;
            $subject    = $request->request->get('subject') ;
            $files      = $form->get('document')->getData() ;
            $videos     = $form->get('videos')->getData() ;
            // $videos     = $request->request ;

            // dd($videos) ;
            $classSchool = $classSchoolRepository->findBy(['id' => $class]) ;
            $subjects = $subjectRepository->findBy(['id' => $subject]) ;

            $lesson->setClassschool($classSchool[0]) ;
            $lesson->setSubject($subjects[0]) ;
            $lesson->setSlug($form->get('title')->getData()) ; 
            
            $this->em->persist($lesson) ;

            if($files){
                for($i=0; $i<count($files); $i++){
                    $filedoc = explode('.',$files[$i]->getClientOriginalName());
                    // $filenamedoc = $filedoc[0].''.uniqid().'.'.$docs[$i]->guessExtension();
                    $filenamedoc = $filedoc[0].'.'.$files[$i]->guessExtension();

                    $document = new Document() ;
                    // $document->setType($form->get('type')->getData());
                    $document->setFile($filenamedoc);
                    $document->setLesson($lesson);

                    $this->em->persist($document);

                    $files[$i]->move($this->getParameter('document_lesson'), $filenamedoc);
                }
            }
            if($videos){
                for($i=0; $i<count($videos); $i++){
                    $filedoc = explode('.',$videos[$i]->getClientOriginalName());
                    // $filenamedoc = $filedoc[0].''.uniqid().'.'.$docs[$i]->guessExtension();
                    $filenamedoc = $filedoc[0].'.'.$videos[$i]->guessExtension();

                    $video = new VideosLesson() ;
                    $video->setFile($filenamedoc);
                    $video->setLesson($lesson);

                    $this->em->persist($video);

                    $videos[$i]->move($this->getParameter('videos_lesson'), $filenamedoc);
                }
            }

            $this->em->flush() ;
            return $this->redirectToRoute('bo_lesson') ;
        }
        
        return $this->render('admin/lesson/newLesson.html.twig', [
            'controller_name' => 'LessonController',
            'form_lesson' => $form->createView(),
            'classSchoolLists' => $classSchoolLists,
        ]);
    }

     /**
     * @Route("/getsubjectperclass", name="getsubjectperclass" , methods={"GET"})
     */
    public function getSubjectPerClass(Request $request , SubjectRepository $subjectRepository): Response
    {
        $datas = [] ;
        $idclassschool = $request->query->get('idclassschool');
        $subjects = $subjectRepository->findBy(['classschool' => $idclassschool]) ;
        foreach ($subjects as $subject) {
            $datas[] = [
                "id" => $subject->getId() ,
                "name" => $subject->getName()
            ] ;
        }

        return new JsonResponse($datas, Response::HTTP_OK);
    }

}
