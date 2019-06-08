<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Entity\User;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, TodoRepository $todoRepository)
    {
        /** @var User $user */
        $user = $this->getUser();

        $todos = $todoRepository->findByUser($user);
        $todo = new Todo();
        $todo->setUser($user);
        $todo->setDone(false);
        $form = $this->createForm(TodoType::class, $todo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($form->getData());
            $entityManager->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('todo/index.html.twig', [
            'todos' => $todos,
            'todoForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/todo/delete/{id}", name="delete")
     */
    public function delete(Todo $todo) {
        /** @var User $user */
        /*$user = $this->getUser();
        if ($todo->getUser()->getId() !== $user->getId()) {
            return $this->redirectToRoute('index');
        }*/

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($todo);
        $entityManager->flush();
        return $this->redirectToRoute('index');
    }
}
