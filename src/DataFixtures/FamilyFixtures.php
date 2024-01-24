<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Family;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FamilyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $family = new Family();
        $family->setUser($this->getReference('user_2'));
        $family->setLastname($faker->lastName());
        $family->setFirstname($faker->firstName());
        $family->setAddress($faker->streetAddress());
        $family->setPostalCode($faker->postcode());
        $family->setCity($faker->city());
        $family->setPhone('0666666666');
        $this->addReference('family_1', $family);
        $manager->persist($family);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
