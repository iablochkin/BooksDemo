<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;

class SaveBooks
{
    public function __construct(
        private EntityManagerInterface $entity,
    ) {
    }

    // Just lost weight from controller
    public function save($data): Book
    {
        $book = new Book();

        $publisher = $this->entity->getRepository(Publisher::class)->find($data['publisher']);
        $autor = $this->entity->getRepository(Author::class)->find($data['author']);
 
        $book->setName($data['name']);
        $book->setYear($data['year']);
        $book->setPublisher($publisher);
        $book->addAuthor($autor);

        return $book;
    }
}