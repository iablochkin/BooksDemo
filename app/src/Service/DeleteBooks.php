<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Book;

class DeleteBooks
{
    public function __construct(
        private EntityManagerInterface $entity,
    ) {
    }

    // Delete books without autors (for command)
    public function delete(): bool
    {
        $books = $this->entity->getRepository(Book::class)->booksWithoutAuthor();

        if (count($books) > 0) {
            foreach($books as $book)
            {
                $this->entity->remove($book);
            }
            $this->entity->flush();

            return true;
        } else {
            return false;
        }
    }
}