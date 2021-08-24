<?php

namespace App\DataFixtures;

use App\Entity\Blogpost;
use App\Entity\Categorie;
use App\Entity\Peinture;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        // Création d'un utilisateur
        $user = new User();

        $user->setEmail('banana@test.com')
            ->setPrenom($faker->firstName)
            ->setNom($faker->lastName)
            ->setRoles(['ROLE_PEINTRE'])
            ->setTelephone($faker->phoneNumber)
            ->setAPropos($faker->text);

        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);

        $manager->persist($user);


        // Création de 10 blogpost
        for ($i=0; $i < 10; $i++) {
         $blogpost = new Blogpost();

         $blogpost->setTitre($faker->word(3, true))
             ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
             ->setContenu($faker->text(350))
             ->setSlug($faker->slug(3))
             ->setFile('Dk55.jpg')
             ->setPublication($faker->dateTimeBetween('-6 month', 'now'))
             ->setUser($user);


         $manager->persist($blogpost);

        }

        // Création de 5 Catégories
        for ($k=0; $k < 5; $k++) {

            $categorie = new Categorie();

            $categorie->setNom($faker->word)
                ->setDescription($faker->text)
                ->setSlug($faker->slug);

            $manager->persist($categorie);

            //Création de 2 Peintures/catégorie
            for ($j=0; $j < 2; $j++) {
                $peinture = new Peinture();

                $peinture->setNom($faker->word(3, true))
                    ->setLargeur($faker->randomFloat(2,20,60))
                    ->setHauteur($faker->randomFloat(2, 20,60))
                    ->setEnVente($faker->randomElement([true, false]))
                    ->setDateRealisation($faker->dateTimeBetween('-6 month', 'now'))
                    ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
                    ->setDescription($faker->text)
                    ->setPrix($faker->randomFloat(2, 100, 9999))
                    ->setPortfolio($faker->randomElement([true, false]))
                    ->setUser($user)
                    ->setFile('tableau_gaming_donkey_kong.jpg')
                    ->setSlug($faker->slug)
                    ->addCategorie($categorie);

                $manager->persist($peinture);

            }
        }

        $manager->flush();

    }
}
