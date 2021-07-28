<?php

namespace App\Controller\fo;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RulesController extends AbstractController
{
    /**
     * @Route("/rules", name="rules")
     */
    public function index(): Response
    {
        //in schedule front
        return $this->render('rules/index.html.twig', [
            'controller_name' => 'RulesController',
        ]);
    }
}
