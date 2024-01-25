<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Calendar;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CalendarFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $calendar = new Calendar();
            $calendar->setCreche($this->getReference('creche_1'));
            $calendar->setTitle($faker->sentence());
            $this->addReference('calendar_' . $i, $calendar);

            $startDate = $faker->dateTimeThisMonth();
            $endDate = $faker->dateTimeBetween($startDate, $startDate->format('Y-m-d H:i:s') . ' +7 days');

            $calendar->setStart($startDate);
            $calendar->setEnd($endDate);
            $calendar->setDescription($faker->text());
            $calendar->setAllDay($faker->boolean());
            $calendar->setBackgroundColor($faker->hexColor());
            $calendar->setTextColor($faker->hexColor());

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
