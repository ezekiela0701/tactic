<?php

namespace App\Controller\fo;

use App\Repository\ScheduleRepository;
use App\Repository\ClassSchoolRepository;
use App\Repository\RulesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/student")
*/
class ScheduleController extends AbstractController
{
    protected $em ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }
    /**
     * @Route("/schedule", name="fo_schedule")
     */
    public function index(ScheduleRepository $scheduleRepository , ClassSchoolRepository $classSchoolRepository
    , RulesRepository $rulesRepository): Response
    {
        $classToFind    = $classSchoolRepository->findBy(['slug' =>$this->getUser()->getFirstName() ]) ;
        $schedule       = $scheduleRepository->findBy(['classschool' =>$classToFind , 'status' => true ]);
        $rules          = $rulesRepository->findAll() ; 

        return $this->render('fo/schedule/index.html.twig', [
            'controller_name' => 'ScheduleController',
            'schedule'        => $schedule,
            'rules'           => $rules
        ]);
    }
}
