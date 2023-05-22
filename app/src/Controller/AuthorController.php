<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'add_author', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->request->all();

        $author = new Author();

        $author->setFirstName($data['first_name']);
        $author->setSecondName($data['second_name']);

        $errors = $validator->validate($book);

        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }

        $entityManager->persist($author);
        $entityManager->flush();

        return $this->json('Author was added');
    }

    #[Route('/author/{id}', name: 'delete_author', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Author $author): JsonResponse
    {
        $entityManager->remove($author);
        $entityManager->flush();

        return $this->json('Author was deleted');
    }
}
