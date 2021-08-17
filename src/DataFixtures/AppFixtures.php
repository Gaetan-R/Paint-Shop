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
            ->setTelephone($faker->phoneNumber)
            ->setAPropos($faker->text);

        $password = $this->encoder->encodePassword($user, 'password');
        $user->setPassword($password);

        $manager->persist($user);

        $manager->flush();

        // Création de 10 blogpost
        for ($i=0; $i < 10; $i++) {
         $blogpost = new Blogpost();

         $blogpost->setTitre($faker->word(3, true))
             ->setCreatedAt($faker->dateTimeBetween('-6 month', 'now'))
             ->setContenu($faker->text(350))
             ->setUser($user);
          //   ->setSlug($faker->slug(3));

         $manager->persist($blogpost);

         $manager->flush();

        }

        // Création de 5 Catégories
        for ($k=0; $k < 5; $k++) {

            $categorie = new Categorie();

            $categorie->setNom($faker->word)
                ->setDescription($faker->text);

            $manager->persist($categorie);

            //Création de 2 Peintures/catégorie
            for ($j=0; $j < 2; $j++) {
                $peinture = new Peinture();

                $peinture->setNom($faker->word(3, true))
                    ->setLargeur($faker->randomFloat(2,20,60))
                    ->setHauteur($faker->randomFloat(2, 20,60))
                    ->setVente($faker->randomElement([true, false]))
                    ->setDateRealisation($faker->dateTimeBetween('-6 month', 'now'))
                    ->setDescription($faker->text)
                    ->setPrix($faker->randomFloat(2, 100, 9999))
                    ->setUser($user)
                    ->setCategorie($categorie);

                $manager->persist($peinture);

            }
        }

        $manager->flush();

    }
}
