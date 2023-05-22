<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Get books list with relations
    public function bookList(): array
    {      
        $qb = $this->createQueryBuilder('b')
            ->select(array('b.id', 'b.name', 'b.year'))
            ->addSelect('p.name publisher_name')
            ->addSelect('a.second_name author_second_name')
            ->leftJoin('b.publisher', 'p', 'WITH', 'b.publisher = p.id')
            ->leftJoin('b.authors', 'a')
            ->getQuery()
            ->getArrayResult();
 
        return $qb;
        
    }

    // Get books list without author
    public function booksWithoutAuthor(): array
    {
        $qb = $this->createQueryBuilder('b')
        ->select(array('b'))
        ->leftJoin('b.authors', 'a')->addSelect('a');
        $qb->andWhere($qb->expr()->isNull('a.id'));

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }
}
