<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Note;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\NoteType;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NoteController extends AbstractController
{

    private $entityManager;
    private $client;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $client)
    {
        $this->entityManager = $entityManager;
        $this->client = $client;

    }

    #[Route('/notes', name: 'add_note', methods: 'POST')]
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($data)) {
            if (!array_key_exists('title', $data) || empty($data['title'])) {
                return new JsonResponse([
                    'status' => 'error',
                    'error_message' => "The title field isnt set or is empty!"
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
            $form = $this->createForm(NoteType::class, new Note());
            $form->submit($data);
            if ($form->isValid() === false) {
                return new JsonResponse(['status' => 'error'], JsonResponse::HTTP_BAD_REQUEST);
            }

            $this->entityManager->persist($form->getData());
            $this->entityManager->flush();
            return new JsonResponse(['status' => 'Note created!'], JsonResponse::HTTP_CREATED);
        } else {
            return new JsonResponse(['status' => 'error'], JsonResponse::HTTP_BAD_REQUEST);
        }

    }

    #[Route('/notes/{id}', name: 'get_one_note', methods: 'GET')]
    public function get($id): JsonResponse
    {
        $note = $this->entityManager->find(Note::class, $id);

        if (!$note) {
            return new JsonResponse(['status' => 'error', 'error_message' => 'No note exists with the provided ID'], JsonResponse::HTTP_NOT_FOUND);
        }

        $note_data = [
            'title' => $note->getTitle(),
            'text' => $note->getText()
        ];

        return new JsonResponse(['note' => $note_data], JsonResponse::HTTP_OK);
    }

    #[Route('/notes', name: 'get_all_notes', methods: 'GET')]
    public function getAll(Request $request): JsonResponse
    {
        $noteRepository = $this->entityManager->getRepository(Note::class);
        $notes = $noteRepository->findAll();
        if (!empty($notes)) {
            $note_data = [];
            foreach ($notes as $note) {
                $tmp['title'] = $note->getTitle();
                $tmp['text'] = $note->getText();
                $note_data[] = $tmp;
            }
            return new JsonResponse(['all notes' => $note_data], JsonResponse::HTTP_OK);
        } else {
            return new JsonResponse(['No notes available'], JsonResponse::HTTP_NOT_FOUND);
        }
    }

    #[Route('/notes/{id}', name: 'update_note', methods: 'PUT')]
    public function update($id, Request $request): JsonResponse
    {
        $note = $this->entityManager->find(Note::class, $id);

        if (!$note) {
            return new JsonResponse(['status' => 'error', 'error_message' => 'No note exists with the provided ID'], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (!empty($data)) {
            // the title cannot be empty
            if (array_key_exists('title', $data) && !empty($data['title'])) {
                $note->setTitle($data['title']);
            } else {
                return new JsonResponse([
                    'status' => 'error',
                    'error_message' => "The title field isnt set or is empty!"
                ], JsonResponse::HTTP_BAD_REQUEST);
            }
            // the text can be empty
            if (array_key_exists('text', $data)) {
                $note->setText($data['text']);
            }

            $this->entityManager->flush();
            return new JsonResponse(['updated note', 'data' => $data], JsonResponse::HTTP_OK);
        } else {
            return new JsonResponse([
                'status' => 'error',
                'error_message' => "No data was provided!"
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

    }

    #[Route('/notes/{id}', name: 'delete_note', methods: 'DELETE')]
    public function delete($id): JsonResponse
    {
        $note = $this->entityManager->getRepository(Note::class)->find($id);
        if (!$note) {
            return new JsonResponse(['status' => 'error', 'error_message' => 'No note exists with the provided ID'], JsonResponse::HTTP_NOT_FOUND);
        }
        $this->entityManager->remove($note);
        $this->entityManager->flush();
        return new JsonResponse(['status' => 'Note deleted'], JsonResponse::HTTP_NO_CONTENT);
    }
}