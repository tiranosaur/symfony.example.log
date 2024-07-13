<?php

namespace App\DataFixtures;

use App\Entity\EntityA;
use App\Entity\EntityB;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ABFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $dataA = [
            EntityA::create("a"),
            EntityA::create("b"),
            EntityA::create("c"),
            EntityA::create("d"),
        ];

        $dataB = [
            EntityB::create("aaa"),
            EntityB::create("bbb"),
            EntityB::create("ccc"),
            EntityB::create("ddd"),
        ];

        $dataA[0]->addEntityB($dataB[0]);
        $dataA[0]->addEntityB($dataB[1]);
        $dataA[0]->addEntityB($dataB[2]);

        $data = array_merge($dataA, $dataB);

        foreach ($data as $entity) {
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
