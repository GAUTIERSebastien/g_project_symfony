<?php

namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use App\Form\FormProjectsType;
use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projects')]
class ProjectsController extends AbstractController
{
    #[Route('/list', name: 'project_list')]
    public function index(ProjectsRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous ne pouvez pas accéder à cette url');
        $projects = $repo->findAll();
        return $this->render('projects/index.html.twig', [
            'controller_name' => 'Liste des projects',
            'projects' => $projects,
        ]);
    }


    #[Route('/show/{id}', name: 'project_show')]
    public function show(?Projects $projects)
    {
        if ($projects === null) {
            return $this->redirectToRoute('project_list');
        }
        return $this->render('projects/show.html.twig', [
            'projects' => $projects,
        ]);
    }

    #[Route('/new', name: 'project_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous ne pouvez pas accéder à cette url');
        $project = new Projects();
        $form = $this->createForm(FormProjectsType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($project);
            $em->flush();
            $this->addFlash('success', 'Le project a bien été ajouté');
            return $this->redirectToRoute('project_list');
        }

        return $this->render('projects/new.html.twig', [
            'title' => 'Ajouter un project',
            'form' => $form,
        ]);
    }

    #[Route('/edit/{id}', name: 'project_edit')]

    public function edit(Request $request, ?Projects $project, EntityManagerInterface $em): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous ne pouvez pas accéder à cette url');
        if ($project === null) {
            return $this->redirectToRoute('project_list');
        }
        $form = $this->createForm(FormProjectsType::class, $project);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Le project a bien été modifié');
            return $this->redirectToRoute('project_list');
        }

        return $this->render('projects/new.html.twig', [
            'title' => 'Editer un project',
            'form' => $form,
            'button_label' => 'enregistrer',
        ]);
    }

    #[Route('/delete/{id}', name: 'project_delete')]
    public function delete(Request $request, Projects $project, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous ne pouvez pas accéder à cette url');

        $entityManager->remove($project);
        $entityManager->flush();


        return $this->redirectToRoute('project_list', [], Response::HTTP_SEE_OTHER);
    }
}
