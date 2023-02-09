<?php

namespace App\Domain\DataFixtures;

use App\Domain\Entity\FirstTest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FirstTestFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new FirstTest())->setPropertyStr('a')->setPropertyInt(1)->setPropertyBool(true));
        $manager->persist((new FirstTest())->setPropertyStr('b')->setPropertyInt(2)->setPropertyBool(true));
        $manager->persist((new FirstTest())->setPropertyStr('c')->setPropertyInt(3)->setPropertyBool(false));

        $manager->flush();
    }
}
