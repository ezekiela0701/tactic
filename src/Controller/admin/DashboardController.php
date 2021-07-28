<?php

namespace App\Controller\admin;

use App\Repository\ContactMessageRepository;
use App\Repository\TeacherRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
     * @Route("/admin")
     */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="dashboard")
     */
    public function index(UserRepository $userRepository , TeacherRepository $teacherRepository , ContactMessageRepository $contactMessageRepository): Response
    {
        $users = $userRepository->findAll() ;
        $teachers = $teacherRepository->findAll() ;
        $messages = $contactMessageRepository->findAll() ;
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name'   => 'DashboardController',
            'users'             => count($users),
            'teachers'          => count($teachers),
            'messages'          => count($messages),
        ]);
    }
}
