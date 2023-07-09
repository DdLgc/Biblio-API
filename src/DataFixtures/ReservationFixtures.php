<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $reservationsData = [
            [1, [1], new DateTime('2023-07-07 17:33:33'), new DateTime('2023-06-07 17:33:33'), null],
        ];

        foreach ($reservationsData as $reservationData) {
            $reservation = new Reservation();
            $reservation->setReturnDateInitial($reservationData[2]);
            $reservation->setLoanDate($reservationData[3]);
            $reservation->setReelReturnDate($reservationData[4]);
            $reservation->setUser($this->getReference('user_' . $reservationData[0]));
            foreach ($reservationData[1] as $bookId) {
                $book = $this->getReference('book_' . $bookId);
                $reservation->addIdBook($book);
            }

            $manager->persist($reservation);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            BookFixtures::class
        ];
    }
}