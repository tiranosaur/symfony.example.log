<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserRoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $data = [
            Role::create(1, 'ROLE_USER'),
            Role::create(2, 'ROLE_ADMIN'),
            Role::create(3, 'ROLE_SUPER_ADMIN'),
        ];

        foreach ($data as $item) {
            $manager->persist($item);
        }
        $manager->flush();

        $user = User::create(1,'tiranosaur', '111');
        $user->addRole($data[2]);

        $manager->persist($user);
        $manager->flush();
    }
}
