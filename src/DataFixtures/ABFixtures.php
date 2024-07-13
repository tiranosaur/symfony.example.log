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
            EntityB::create("aaa", $dataA[0]),
            EntityB::create("bbb", $dataA[0]),
            EntityB::create("ccc", $dataA[0]),
            EntityB::create("ddd", $dataA[1]),
            EntityB::create("eee", $dataA[1]),
            EntityB::create("fff", $dataA[2]),
        ];

        $data = array_merge($dataA, $dataB);
        foreach ($data as $item) {
            $manager->persist($item);
        }

        $manager->flush();
    }
}
