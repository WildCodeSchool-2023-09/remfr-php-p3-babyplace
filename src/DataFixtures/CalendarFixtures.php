<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Calendar;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

;

class CalendarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $calendar = new Calendar();
            $calendar->setCreche($this->getReference('creche_1'));
            $calendar->setTitle($faker->sentence());
            $this->setReference('calendar_' . $i, $calendar);
            for ($j = 0; $j < 7; $j++) {
                $calendar->setStart($faker->dateTime());
                $calendar->setEnd($faker->dateTime());
                $calendar->setDescription($faker->text());
                $calendar->setAllDay($faker->boolean());
                $calendar->setBackgroundColor($faker->hexcolor());
                $calendar->setTextColor($faker->hexcolor());
            }
            $manager->persist($calendar);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CrecheFixtures::class,
        ];
    }
}
