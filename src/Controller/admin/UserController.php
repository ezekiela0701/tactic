<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
* @Route("/admin")
*/
class UserController extends AbstractController
{
    protected $em ; 
    protected $encoder ; 
    public function __construct(EntityManagerInterface $em , UserPasswordEncoderInterface $encoder)
    {
        $this->em = $em ; 
        $this->encoder = $encoder ; 
    }

    /**
     * @Route("/user", name="user_list")
     */
    public function index(UserRepository $userRepository): Response
    {
        $userLists = $userRepository->findAll() ;
        return $this->render('admin/user/index.html.twig', [
            'controller_name' => 'UserController',
            'userLists'       => $userLists ,
        ]);
    }

     /**
     * @Route("/user/new", name="user_register")
     * @Route("/user/update/{id}", name="user_updated")
     */
    public function newUser(User $user=null , Request $request): Response
    {
        if(!$user){
            $user = new User() ; 
        }
        $form = $this->createForm(UserType::class , $user) ; 

        $form->handleRequest($request) ; 
        if($form->isSubmitted() && $form->isValid()){
            $user->setName("Identifiant") ;
            if ($user->getType() == "Professeur") {
                $user->setRoles(["ROLE_PROF"]);
                $user->setType("Professeur");
            }
            else{
                $user->setRoles(["ROLE_ETUDIANT"]);
                $user->setType("Etudiant");
            }
            // $user->setRoles(["ROLE_ADMIN"]);
            $hash= $this->encoder->encodePassword($user , $user->getPassword());
            $user->setPassword($hash);
            $this->em->persist($user) ; 
            $this->em->flush() ; 
            return  $this->redirectToRoute('user_list') ; 
        }
        return $this->render('admin/user/new.html.twig', [
            'controller_name' => 'UserController',
            'formUser' => $form->createView(),
            'editMode' => $user->getId() !=null ,
            'user'       => $user ,
        ]);
    }

    /**
     * @Route("/user/delete/{id}" ,name="user_delete")
     */
    public function deleteTeacher(UserRepository $userRepository ,User $user , Request $request , $id ){
        // $userDelete = $userRepository->findById($id) ;

        $this->em->remove($user);
        $this->em->flush();

        return $this->redirectToRoute("user_list");
    }

}
