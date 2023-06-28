<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $usersData = [
            [1, '1234', 'John', 'Doe', 'john@doe.com', ' role'],
            [2, '5678', 'Jane', 'Doe', 'jane@doe.com', 'role'],
        ];

        foreach ($usersData as $userData) {
            $user = new User();
            $user->setPassword($userData[1]);
            $user->setName($userData[2]);
            $user->setSurName($userData[3]);
            $user->setEmail($userData[4]);
            $user->setRole($userData[5]);

            $manager->persist($user);
            $this->addReference('user_' . $userData[0], $user);
        }
        $manager->flush();
    }
}