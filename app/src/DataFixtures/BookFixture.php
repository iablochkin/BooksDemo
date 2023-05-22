<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Publisher;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Insert simple data in database
        for ($i = 1; $i <= 3; $i++) {
            $publisher = new Publisher;
            $publisher->setName('namePublisher' . $i);
            $publisher->setAddress('addressPublisher'. $i);

            $manager->persist($publisher);

            $author = new Author;
            $author->setFirstName('firstAuthorName' . $i);
            $author->setSecondName('secondAuthorName'. $i);

            $manager->persist($author);

            for ($k = 1; $k <= 2; $k++) {
                $book = new Book();
                $book->setName('bookName'.$i.'.'.$k);
                $book->setYear(rand(1950, 2025));
                $book->setPublisher($publisher);
                $book->addAuthor($author);

                $manager->persist($book);
            }
        }

        $manager->flush();
    }
}
