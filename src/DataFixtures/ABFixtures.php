<?php declare(strict_types=1);

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
            EntityB::create("aaa", null),
            EntityB::create("bbb", $dataA[1]),
            EntityB::create("ccc", $dataA[2]),
            EntityB::create("ddd", $dataA[3]),
        ];

        $data = array_merge($dataA, $dataB);
        foreach ($data as $item) {
            $manager->persist($item);
        }

        $manager->flush();
    }
}
