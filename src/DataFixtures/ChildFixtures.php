<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Child;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ChildFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 5; $i++) {
            $child = new Child();
            $child->setFamily($this->getReference('family_' . rand(0, 1)));
            $child->setChildFirstname($faker->firstName());
            $child->setChildLastname($faker->lastName());
            $child->setBirthdate($faker->dateTimeBetween('-3 years', '-1 years'));
            $child->setIsWalking(true);
            $child->setAllergy('Aucune');
            $child->setIsDisabled(true);
            $child->setDisability('Aucun');
            $child->setBirthCertificate('null');
            $child->setDoctorName('Dr. Dupont');
            $child->setVaccine('null');
            $child->setInsurance('null');
            $this->addReference('child_' . $i, $child);
            $manager->persist($child);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FamilyFixtures::class,
        ];
    }
}
