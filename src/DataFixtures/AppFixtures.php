<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //Utilisation de la librairie Faker pour créer des données réalistes
        $faker = Factory::create('fr-FR');

        //boucle pour créer 30 annonces dans la BDD
        for ($i = 1; $i <= 30; $i++) {
            //Création d'une unstance de l'annonce
            $ad = new Ad();

            //Récupération de données vraissemblable grâce à la librairie Faker
            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('<p></p>', $faker->paragraphs(5)) . '</p>';

            //Hydratation de l'instance de l'annonce
            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 6));

            //Boucle pour créer des images associées à nos annonces
            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                //Création d'une instance de Image
                $image = new Image();

                //Récupération de données vraissemblables grâce à la librairie Faker
                $url = $faker->imageUrl();
                $caption = $faker->sentence();

                //Hydratation de l'objet $image
                $image->setUrl($url)
                    ->setCaption($caption)
                    ->setAd($ad);

                //Prevenir Doctrine que nous allons faire persister cette instance
                $manager->persist($image);

            }

            //Prevenir Doctrine que nous allons faire persister cette instance
            $manager->persist($ad);

        }
        //Connexion à la BDD et enregistrement de toutes les instances d'annonce créées
        $manager->flush();
    }
}
