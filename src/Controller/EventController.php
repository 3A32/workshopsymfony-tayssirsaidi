<?php

namespace App\Controller;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'app_event')]
    public function index(): Response
    {
        return $this->render('event/index.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
    //list*****************************

    #[Route('/events', name: 'app_events')]
    public function listEvent(EventRepository $repository)
    {
        $events = $repository->findAll();
        //$formSearch=$this->createForm(type:SearchEventType::class);
        $eventsBytitle=$repository->geteventOrderByTitle();
        return $this->render("event/listEvent.html.twig", array("tabEvents" => $events,"byTitle"=>$eventsBytitle));
        //,"byTitle"=>$eventsBytitle tetzed f terun maa tabevents
    }
//add*********************************
#[Route('/AddEvent', name: 'app_AddEvent')]
public function AddEvent(ManagerRegistry $doctrine, Request $request)
{
    $event = new Event();
    $form = $this->createForm(EventType::class, $event);
    $form->handleRequest($request);
    
    if ($form->isSubmitted()) {
        $em = $doctrine->getManager();
        $em->persist($event);
        $em->flush();
        return $this->redirectToRoute("app_events");
    }
    return $this->renderForm("event/addevent.html.twig", array("form" => $form));

}
//update********************************
#[Route('/updateEvent/{id}',name:'app_updateEvent')]
    public function updateClub(EventRepository $repository,$id,ManagerRegistry $doctrine, Request $request )
    {
        $event= $repository->find($id);
        $form=$this->createForm(EventType::class,$event);
        $form->handleRequest($request);
        if($form->isSubmitted())
{
    $em=$doctrine->getManager();
    
    $em->flush();
    return $this->redirectToRoute("app_events");
}
       
        return $this->renderForm("event/update.html.twig",array("formevent"=>$form));
    }

    //delete************************************
    #[Route('/removeEvent/{id}', name: 'app_removeEvent')]

    public function deleteEvent(ManagerRegistry $doctrine,$id,EventRepository $repository)
    {
        $event= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute("app_events");

    }

}
