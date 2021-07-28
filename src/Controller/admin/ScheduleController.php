<?php

namespace App\Controller\admin;

use App\Entity\Schedule ;
use App\Form\ScheduleType ;
use App\Repository\ScheduleRepository ;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/student")
 */
class ScheduleController extends AbstractController
{
    protected $em ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }
    /**
     * @Route("/schedule", name="bo_student_schedule")
     */
    public function index(ScheduleRepository $scheduleRepository): Response
    {
        $listSchedule = $scheduleRepository->findAll() ;
        return $this->render('admin/schedule/index.html.twig', [
            'controller_name' => 'ScheduleController',
            'listSchedule'    => $listSchedule
        ]);
    }

    /**
     * @Route("/schedule/add", name="bo_student_schedule_add")
     * @Route("/schedule/edit/{id}", name="bo_student_schedule_edit")
     */
    public function addSchedule(Schedule $schedule=null , Request $request , ScheduleRepository $scheduleRepository ): Response
    {
       
        if (!$schedule) {
            $schedule = new Schedule() ; 
        }
        $form = $this->createForm(ScheduleType::class , $schedule) ;

        if ($schedule->getId() !=null ) {
            $routeParams    = $request->attributes->get('_route_params');
            $id             = $routeParams['id']; 
            $scheduleEdit   = $scheduleRepository->findById($id) ;
        }
        else{
            $scheduleEdit   = null ;
        }

        $form->handleRequest($request) ; 
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($schedule) ;
            $this->em->flush() ;

            return $this->redirectToRoute('bo_student_schedule');
        }

        return $this->render('admin/schedule/newSchedule.html.twig', [
            'controller_name'   => 'StudentController',
            'form_schedule'     => $form->createView() , 
            'editMode'          => $schedule->getId() !=null ,
            'scheduleEdit'      => $scheduleEdit ,
        ]);
    }

}
