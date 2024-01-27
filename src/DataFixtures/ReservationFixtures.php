<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $reservation = new Reservation();
            $reservation->setCreche($this->getReference('creche_1'));
            $reservation->setFamily($this->getReference('family_' . rand(0, 1)));
            $reservation->setChild($this->getReference('child_' . rand(0, 4)));
            $reservation->setCalendar($this->getReference('calendar_' . $i));
            $reservation->setStatus(
                ['en attente', 'accepté', 'refusé' , 'annulé'][rand(0, 3)]
            );

            $manager->persist($reservation);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CrecheFixtures::class,
            FamilyFixtures::class,
            CalendarFixtures::class,
        ];
    }
}
