<?php

namespace App\Controller\admin;

use App\Entity\Rules;
use App\Form\RulesType;
use App\Repository\RulesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/admin")
*/
class RulesController extends AbstractController
{
    protected $em ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }

    /**
     * @Route("/rules/add/", name="bo_rules")
     */
    public function add(Request $request , RulesRepository $rulesRepository , Rules $rules =null): Response
    {

        $rules = $rulesRepository->findRules() ;
        if(count($rules)==0){
            $rules = new Rules() ;
            $rules->setContent("Ecriver ici avec les styles vos reglement intérieur");
            $this->em->persist($rules) ;
            $this->em->flush();
        }

        $rules = $this->getRules() ;
        if($rules){
      
            $form = $this->createForm(RulesType::class , $rules) ; 

            $form->handleRequest($request) ; 
            if($form->isSubmitted()&& $form->isValid()){
                $this->em->persist($rules) ; 
                $this->em->flush();
            }
        
            return $this->render('admin/rules/index.html.twig', [
                'controller_name' => 'RulesController',
                'form_rules' => $form->createView() 
            ]);
        }

        return $this->redirectToRoute("bo_rules");
    }
    function getRules(): ? Rules
    {
        return $this->em->getRepository(Rules::class)->getInfo();

    }
}
