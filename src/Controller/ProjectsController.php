<?php

namespace App\Controller;

use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projects')]
class ProjectsController extends AbstractController
{
    #[Route('/list', name: 'projects_list')]
    public function index(ProjectsRepository $repo): Response
    {
        $projects = $repo->findAll();
        return $this->render('projects/index.html.twig', [
            'controller_name' => 'Liste des projects',
            'projects' => $projects,
        ]);
    }


    #[Route('/show/{id}', name: 'project_show')]
    public function show(Projects $projects)
    {
        return $this->render('projects/show.html.twig', [
            'projects' => $projects,
        ]);
    }
}
