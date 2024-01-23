<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private Generator $faker;
    private $userPasswordHasherInterface;
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface){
        $this -> faker = Factory::create('fr_FR');
        $this -> userPasswordHasherInterface = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager): void
    {
        $utlisateurs = [];
        $admin = new Utilisateur();
        $admin -> setEmail('admin@gmail.com') -> setRoles(['Role_USER', 'ROLE_ADMIN']) -> setPassword($this -> userPasswordHasherInterface -> hashPassword($admin, 'admin')) -> setNom("ADMIN") -> setSexe("homme") -> setDateDeNaissance(new DateTimeImmutable('10-12-2000')) -> setPseudo('Administrateur 0') -> setDateDeCreationDuCompte(new DateTimeImmutable('17-01-2024'));
        $utlisateurs[] = $admin;
        $manager -> persist($admin);
        for ($i=0; $i < 10; $i++) { 
            $utilisateur = new Utilisateur();
            $utilisateur -> setEmail($this -> faker -> email()) -> setRoles(['Role_USER']) -> setPassword($this -> userPasswordHasherInterface -> hashPassword($utilisateur, 'utilisateur')) -> setNom($this->faker->name()) -> setSexe("femme") -> setDateDeNaissance($this -> faker -> dateTime()) -> setPseudo('Utilisateur'.$i) -> setDateDeCreationDuCompte($this -> faker -> dateTime());
            $utlisateurs[] = $utilisateur;
            $manager -> persist($utilisateur);
            // $this -> faker -> randomDigit()
        }
        $manager->flush();
    }
}
