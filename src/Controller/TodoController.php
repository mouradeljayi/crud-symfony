<?php

namespace App\Controller;

use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    private $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    #[Route('/todos/', name: 'add_todo', methods:'POST')]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $title = $data['title'];
        $this->todoRepository->saveTodo($title);
        
        return new JsonResponse(['status' => 'Todo created!'], Response::HTTP_CREATED);
    }

    #[Route('/todos/{id}', name: 'get_todo', methods:'GET')]
    public function get($id): JsonResponse
    {
        $todo = $this->todoRepository->findOneBy(['id' => $id]);
        $data = [
            'id' => $todo->getId(),
            'title' => $todo->getTitle(),
        ];
        
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/todos/', name: 'get_todos', methods:'GET')]
    public function getAll(): JsonResponse
    {
        $todos = $this->todoRepository->findAll();
        $data = [];

        foreach($todos as $todo) {
            $data[] = [
                'id' => $todo->getId(),
                'title' => $todo->getTitle()
            ];
        }
        
        return new JsonResponse($data, Response::HTTP_OK);
    }

    #[Route('/todos/{id}', name: 'update_todo', methods:'PUT')]
    public function update($id, Request $request): JsonResponse
    {
        $todo = $this->todoRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);
        empty($data['title']) ? true : $todo->setTitle($data['title']);

        $updateTodo = $this->todoRepository->updateTodo($todo);
        
        return new JsonResponse($updateTodo->toArray(), Response::HTTP_OK);
    }

    #[Route('/todos/{id}', name: 'delete_todo', methods:'DELETE')]
    public function delete($id): JsonResponse
    {
        $todo = $this->todoRepository->findOneBy(['id' => $id]);
        $this->todoRepository->removeTodo($todo);
        
        return new JsonResponse(['status' => 'Todo Deleted'], Response::HTTP_NO_CONTENT);
    }

    
}
