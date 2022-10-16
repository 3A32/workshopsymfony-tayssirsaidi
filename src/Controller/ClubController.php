<?php
//namespace AppBundle\Form\Type;
namespace App\Controller;
//use App\Controller\ClubType;
use Doctrine\DBAL\Schema\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use App\Repository\ClubRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Club;
//use App\Form\ClubType;


class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    #[Route('/clubs', name: 'app_clubs')]
    public function listClub(ClubRepository $repository)
    {
        $clubs = $repository->findAll();
        return $this->render("club/listClub.html.twig", array("tabClubs" => $clubs));
    }

   
    #[Route('/AddClub', name: 'app_AddClub')]
    public function AddClub(ManagerRegistry $doctrine, Request $request)
    {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);
        //$club->setName("club2");
        //$club->setDescription("desc2");
        //$em=$this->getDoctrine()->getManager(); version 9dima
        if ($form->isSubmitted()) {
            $em = $doctrine->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute("app_clubs");
        }
        return $this->renderForm("club/addClub.html.twig", array("formClub" => $form));
    }
    #[Route('/updateClub/{id}',name:'app_updateClub')]
    public function updateClub(ClubRepository $repository,$id,ManagerRegistry $doctrine, Request $request )
    {
        $club= $repository->find($id);
        $form=$this->createForm(ClubType::class,$club);
        $form->handleRequest($request);
        if($form->isSubmitted())
{
    $em=$doctrine->getManager();
    
    $em->flush();
    return $this->redirectToRoute("app_clubs");
}
       
        return $this->renderForm("club/update.html.twig",array("formClub"=>$form));
    }
    #[Route('/removeClub/{id}', name: 'app_removeClub')]

    public function deleteClub(ManagerRegistry $doctrine,$id,ClubRepository $repository)
    {
        $club= $repository->find($id);
        $em= $doctrine->getManager();
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("app_clubs");

    }

                           

}
