<?php

namespace App\Controller\fo;

use App\Entity\ContactMessage;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ContactController extends AbstractController
{
    protected $em ;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em ;
    }
    /**
     * @Route("/contact", name="contact_fo")
     */
    public function index(ContactRepository $contactRepository): Response
    {
        $contact = $contactRepository->findAll() ; 
        return $this->render('fo/contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $contact
        ]);
    }
    /**
     * @Route("/contact/add", name="contact_fo_add_message")
     */
    public function addMessage(Request $request){

        if($request->request->count() > 0){
            $name = $request->request->get('name') ;
            $phonenumber = $request->request->get('phonenumber');
            $subject = $request->request->get('subject');
            $message = $request->request->get('message');

            $contactMessage = new ContactMessage() ;

            $contactMessage->setName($name)
                           ->setTelephone($phonenumber)
                           ->setSubject($subject)
                           ->setMessage($message)
                           ->setCreated(new \DateTime()) ;
            $this->em->persist($contactMessage) ;
            $this->em->flush() ;

            // return $this->redirectToRoute('contact_fo') ;
            return new Response("Message envoyer avec succes nous vous contacterons le plus vite possible , <br>
            L'equipe <b>Tactic</b>") ;
            
        }

    }
}
