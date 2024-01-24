<?php

namespace App\DataFixtures;

use App\Entity\Child;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use DateTime;

class ChildFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $child = new Child();
        $child->setFamily($this->getReference('family_1'));
        $child->setChildFirstname('Jean');
        $child->setChildLastname('Dupont');
        $child->setBirthdate(new DateTime('2018-01-01'));
        $child->isIsWalking();
        $child->setAllergy('Aucune');
        $child->isIsDisabled();
        $child->setDisability('Aucun');
        $child->setBirthCertificate('null');
        $child->setDoctorName('Dr. Dupont');
        $child->setVaccine('null');
        $child->setInsurance('null');

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FamilyFixtures::class,
        ];
    }
}
