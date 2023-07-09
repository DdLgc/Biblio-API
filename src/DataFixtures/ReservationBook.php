<?php

namespace App\DataFixtures;

use App\Entity\ReservationBook;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReservationBookFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $reservationBooksData = [
            ['reservation_1', 'book_9'],
            ['reservation_2', 'book_10'],
        ];

        foreach ($reservationBooksData as $reservationBookData) {
            $reservationBook = new ReservationBook();
            $reservationBook->setReservation($this->getReference($reservationBookData[0]));
            $reservationBook->setBook($this->getReference($reservationBookData[1]));

            $manager->persist($reservationBook);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ReservationFixtures::class,
            BookFixtures::class,
        );
    }
}
