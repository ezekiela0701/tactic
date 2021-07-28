<?php

namespace App\Controller\admin;

use App\Entity\DocumentExam;
use App\Entity\Exam;
use App\Form\ExamType;
use App\Repository\ExamRepository;
use App\Repository\ClassSchoolRepository;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/admin/exam")
*/
class ExamController extends AbstractController
{
    protected $em ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }
    /**
     * @Route("/", name="bo_exam")
     */
    public function index(ExamRepository $examRepository): Response
    {
        $exams = $examRepository->findAll() ;
        return $this->render('admin/exam/index.html.twig', [
            'controller_name' => 'ExamController',
            'exams'           => $exams ,
        ]);
    }

    
     /**
     * @Route("/create", name="bo_exam_create")
     * @Route("/edit/{id}", name="bo_exam_edit")
     */
    public function addLesson(Request $request , Exam $exam =null , ClassSchoolRepository $classSchoolRepository ,
    SubjectRepository $subjectRepository): Response
    {
        if (!$exam) {
            $exam = new Exam() ;
        }
        $classSchoolLists = $classSchoolRepository->findBy(['status' => 1]) ;

        $form = $this->createForm(ExamType::class , $exam ) ;
        
        $form->handleRequest($request) ;
        
        if($form->isSubmitted()&& $form->isValid()){
            $class      = $request->request->get('class') ;
            $subject    = $request->request->get('subject') ;
            $files      = $form->get('document')->getData() ;

            $classSchool = $classSchoolRepository->findBy(['id' => $class]) ;
            $subjects = $subjectRepository->findBy(['id' => $subject]) ;

            $exam->setClassschool($classSchool[0]) ;
            $exam->setSubject($subjects[0]) ;
            $exam->setSlug($class.$subjects[0]->getName().$form->get('trimester')->getData()) ;
            
            $this->em->persist($exam) ;
            
            if($files){
                for($i=0; $i<count($files); $i++){
                    $filedoc = explode('.',$files[$i]->getClientOriginalName());
                    // $filenamedoc = $filedoc[0].''.uniqid().'.'.$docs[$i]->guessExtension();
                    $filenamedoc = $filedoc[0].'.'.$files[$i]->guessExtension();

                    $document = new DocumentExam() ;
                    $document->setType("file");
                    $document->setFile($filenamedoc);
                    $document->setExam($exam);

                    $this->em->persist($document);

                    $files[$i]->move($this->getParameter('document_exam'), $filenamedoc);
                }
            }

            $this->em->flush() ;
            return $this->redirectToRoute('bo_exam') ;
        }
        
        return $this->render('admin/exam/newExam.html.twig', [
            'controller_name'   => 'LessonController',
            'form_exam'         => $form->createView(),
            'classSchoolLists'  => $classSchoolLists,
            'editMode'          => $exam->getId() !=null,
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
