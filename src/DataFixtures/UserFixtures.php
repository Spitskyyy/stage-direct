<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
        // Utilisateur admin : Emeric Grall
        $admin = new User();
        $admin->setEmail('emeric.grall@orange.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'Testtest'));
        $manager->persist($admin);

        // Utilisateur standard : Eva
        $user = new User();
        $user->setEmail('eva@example.com'); // Remplacez par un email valide si nécessaire
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'Testest'));
        $manager->persist($user);

        // Enregistrer dans la base de données
        $manager->flush();
    }
}
