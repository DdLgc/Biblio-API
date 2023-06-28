<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Book;
use DateTime;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $booksData = [
            [1,'Les Fleurs du mal (1857)', 'Baudelaire', '0000-0001', 'Description...', new DateTime('2023-06-14 15:06:13'), false,'../../assets/img/book/les_miserables.jpg'],
            [2,'les misérables', 'Baudelaire', '0000-0002', 'Description...', new DateTime('2023-06-14 15:06:13'), false,'../../assets/img/book/les_miserables.jpg'],
            [3,'les misérables', 'Baudelaire', '0000-0002', 'Description...', new DateTime('2023-06-14 15:06:13'), false,'../../assets/img/book/les_miserables.jpg'],
        ];

        foreach ($booksData as $bookData) {
            $book = new Book();
            $book->setTitle($bookData[1]);
            $book->setAutor($bookData[2]);
            $book->setIsbn($bookData[3]);
            $book->setDescription($bookData[4]);
            $book->setPublishingDate($bookData[5]);
            $book->setIsReserved($bookData[6]);
            $book->setUrl($bookData[7]);

            $manager->persist($book);
            $this->addReference('book_' . $bookData[0], $book);
        }
        $manager->flush();
    }
}