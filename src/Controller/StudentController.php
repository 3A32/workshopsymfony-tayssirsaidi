<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(  StudentRepository $student): Response
    {
        
        return $this->render("student/list.html.twig",['students' => $student->findAll(), ]);
               }

    #[Route('/AddClub', name: 'app_AddClub')]
               public function AddClub(ManagerRegistry $doctrine, Request $request)
               {
                   $student = new Student();
                   $form = $this->createForm(ClubType::class, $student);
                   $form->handleRequest($request);
                   
                   if ($form->isSubmitted()) {
                       $em = $doctrine->getManager();
                       $em->persist($student);
                       $em->flush();
                       return $this->redirectToRoute("app_clubs");
                   }
                   return $this->renderForm("club/addClub.html.twig", array("formClub" => $form));
               }

}
