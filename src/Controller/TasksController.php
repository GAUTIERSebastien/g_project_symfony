<?php

namespace App\Controller;

use App\Entity\Tasks;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\FormTasksType;
use App\Repository\TasksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/tasks')]
class TasksController extends AbstractController
{
    #[Route('/list', name: 'task_list')]
    public function index(TasksRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous ne pouvez pas accéder à cette url');
        $tasks = $repo->findAll();
        return $this->render('tasks/index.html.twig', [
            'controller_name' => 'Liste des tâches',
            'tasks' => $tasks,
        ]);
    }

    #[Route('/new', name: 'task_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER', null, 'Vous ne pouvez pas accéder à cette url');
        $task = new Tasks();
        $form = $this->createForm(FormTasksType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();
            $this->addFlash('success', 'La tâche a bien été ajoutée');
            return $this->redirectToRoute('project_show', ['id' => $task->getProjects()->getId()]);
        }

        return $this->render('tasks/new.html.twig', [
            'description' => 'Ajouter une description de tâche',
            'form' => $form,
        ]);
    }
}
