<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type “contributeur” (= auteur)
        $contributor = new User();
        $contributor->setEmail('creche@creche.com');
        $contributor->setRoles(['ROLE_CRECHE']);
        $contributor->setAvatar('null');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $contributor,
            'crechepassword'
        );
        $this->addReference('user_24', $contributor);

        $contributor->setPassword($hashedPassword);
        $manager->persist($contributor);

        // Création d’un utilisateur de type “administrateur”
        $admin = new User();
        $admin->setEmail('parent@parent.com');
        $admin->setRoles(['ROLE_PARENT']);
        $admin->setAvatar('null');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'parentpassword'
        );
        $this->addReference('user_0', $admin);
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);

        $parent = new User();
        $parent->setEmail('test@test.com');
        $parent->setRoles(['ROLE_PARENT']);
        $parent->setAvatar('null');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $parent,
            'testpassword'
        );
        $this->addReference('user_1', $parent);
        $parent->setPassword($hashedPassword);
        $manager->persist($parent);

        // Sauvegarde des 2 nouveaux utilisateurs :
        $manager->flush();
    }
}
