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
['Les Fleurs du mal (1857)', 'Baudelaire', '0000-0001', 'Description...', new DateTime('2023-06-14 15:06:13'), false],
// autres livres
];

foreach ($booksData as $bookData) {
$book = new Book();
$book->setTitle($bookData[0]);
$book->setAutor($bookData[1]);
$book->setIsbn($bookData[2]);
$book->setDescription($bookData[3]);
$book->setPublishingDate($bookData[4]);
$book->setIsReserved($bookData[5]);

$manager->persist($book);
$this->addReference('book_'.$bookData[0], $book);
}

$manager->flush();
}
}