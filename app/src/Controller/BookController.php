<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;
use App\Service\SaveBooks;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Repository\BookRepository;

// use Symfony\Component\Serializer\SerializerInterface;

class BookController extends AbstractController
{
    #[Route('/books', name: 'app_book')]
    public function index(EntityManagerInterface $entity): JsonResponse
    {
        $books = $entity->getRepository(Book::class)->bookList();
        return $this->json($books);
    }

    #[Route('/book', name: 'add_book', methods: ['POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request, ValidatorInterface $validator, SaveBooks $book, BookRepository $bookRepository): JsonResponse
    {
        $data = $request->request->all();
        $result = $book->save($data);
        
        $errors = $validator->validate($book);
        if (count($errors) > 0) {
            return $this->json($errors, 422);
        }
        
        $bookRepository->save($result, true);
        
        return $this->json('Book was added', 201);
        
        // $test = $serializer->denormalize($data, Book::class);
    }

    #[Route('/book/{id}', name: 'delete_book', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, Book $book): JsonResponse
    {
        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json('Book was deleted');
    }
}
