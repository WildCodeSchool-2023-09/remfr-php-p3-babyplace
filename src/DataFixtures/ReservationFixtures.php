<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Reservation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 7; $i++)
        {
            $reservation = new Reservation();
            $reservation->setCreche($this->getReference('creche_1'));
            $reservation->setFamily($this->getReference('family_1'));

            // Utilisation d'une référence de calendrier différente pour chaque réservation
            $calendarReference = 'calendar_' . $i;
            
            // Création d'une nouvelle instance de Reservation pour chaque réservation
            $reservation = new Reservation();
            $reservation->setCreche($this->getReference('creche_1'));
            $reservation->setFamily($this->getReference('family_1'));
            $reservation->setCalendar($this->getReference('calendar_' . $i));
            $reservation->setStatus('en attente');
            $manager->persist($reservation);
            
            // Associer la réservation au calendrier correspondant
            $reservation->setCalendar($this->getReference($calendarReference));

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
