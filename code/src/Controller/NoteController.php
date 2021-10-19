<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class NoteController extends AbstractController
{

    #[Route('/notes', name: 'add_note', methods: 'POST')]
    public function add(Request $request): JsonResponse
    {
        return new JsonResponse(['status' => 'Note created!'], Response::HTTP_CREATED);
    }

    #[Route('/notes/{id}', name: 'get_one_note', methods: 'GET')]
    public function get($id): JsonResponse
    {
        return new JsonResponse(['note'], Response::HTTP_OK);
    }

    #[Route('/notes', name: 'get_all_notes', methods: 'GET')]
    public function getAll(Request $request): JsonResponse
    {
        return new JsonResponse(['all notes'], Response::HTTP_OK);
    }

    #[Route('/notes/{id}', name: 'update_note', methods: 'PUT')]
    public function update($id, Request $request): JsonResponse
    {
        return new JsonResponse(['updated note'], Response::HTTP_OK);
    }

    #[Route('/notes/{id}', name: 'delete_note', methods: 'DELETE')]
    public function delete($id): JsonResponse
    {
        return new JsonResponse(['status' => 'Note deleted'], Response::HTTP_NO_CONTENT);
    }
}
