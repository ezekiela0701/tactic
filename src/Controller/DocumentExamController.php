<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentExamController extends AbstractController
{
    /**
     * @Route("/document/exam", name="document_exam")
     */
    public function index(): Response
    {
        return $this->render('document_exam/index.html.twig', [
            'controller_name' => 'DocumentExamController',
        ]);
    }
}
