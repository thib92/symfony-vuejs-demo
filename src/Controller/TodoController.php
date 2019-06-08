<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(TodoRepository $todoRepository)
    {

        $todos = $todoRepository->findByUser($this->getUser());

        return $this->render('todo/index.html.twig', [
            'todos' => $todos,
        ]);
    }

    /**
     * @Route("/todo/delete/{id}", name="delete")
     */
    public function delete(Todo $todo) {
        if ($todo->getUser() !== $this->getUser()) {
            return $this->redirectToRoute('index');
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($todo);
        return $this->redirectToRoute('index');
    }
}
