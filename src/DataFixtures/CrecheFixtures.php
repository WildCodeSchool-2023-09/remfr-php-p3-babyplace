<?php

namespace App\DataFixtures;

use App\Entity\Team;
use App\Entity\User;
use App\Entity\Creche;
use App\Entity\Schedule;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CrecheFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer un utilisateur depuis la base de données
        $user = $manager->getRepository(User::class)->findOneBy(['email' => 'contributor@monsite.com']);

        $creche = new Creche();
        $creche->setUser($user);
        $creche->setIntroduction('Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Sed non risus. Suspendisse lectus tortor,
        dignissim sit amet, adipiscing nec, ultricies sed, dolor.');
        $creche->setName('Crèche des petits');
        $creche->setLocalisation('1 rue de la crèche');
        $creche->setPostCode(75000);
        $creche->setCity('Paris');
        $creche->setPhoneNumber('0123456789');
        $creche->setInsuranceNumber('123456789');
        $creche->setLegalStatus('SARL');
        $creche->setRules('Lorem ipsum dolor sit amet, consectetur');
        $manager->persist($creche);
        $manager->flush();

        // Récupérer la crèche depuis la base de données
        $creche = $manager->getRepository(Creche::class)->findOneBy(['name' => 'Crèche des petits']);

        $schedule = new Schedule();
        $schedule->setCreche($creche);
        $schedule->setWeekdays('Lundi');
        $schedule->setOpeningHours('08:00');
        $schedule->setClosingHours('18:00');
        $manager->persist($schedule);

        $team = new Team();
        // Associer la crèche à l'équipe
        $team->setCreche($creche);
        $team->setTeamFirstname('Jean');
        $team->setTeamLastname('Dupont');
        $team->setFonction('Directeur');
        $team->setPhoto('photo.jpg');
        $manager->persist($team);

        // Appeler flush une seule fois à la fin
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
