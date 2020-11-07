<?php

namespace App\DataFixtures;

use App\Entity\LodgingCategory;
use App\Entity\LodgingType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LodgingTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /**
         *  APPARTEMENT
         */

        $category = new LodgingCategory();
        $category->setName('Appartement');
        $manager->persist($category);

        $type = new LodgingType();
        $type->setName("T1");
        $type->setLodgingCategory($category);
        $manager->persist($type);


        $type = new LodgingType();
        $type->setName("T2");
        $type->setLodgingCategory($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("T3");
        $type->setLodgingCategory($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("T4");
        $type->setLodgingCategory($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("T5");
        $type->setLodgingCategory($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("Loft");
        $type->setLodgingCategory($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("Duplex");
        $type->setLodgingCategory($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("Triplex");
        $type->setLodgingCategory($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("Sousplex");
        $type->setLodgingCategory($category);
        $manager->persist($type);

        /*
         * MAISON
         */
        $category = new LodgingCategory();
        $category->setName('Maison');
        $manager->persist($category);

        /*
         * Terrain
         */
        $category = new LodgingCategory();
        $category->setName('Terrain');
        $manager->persist($category);

        /*
         * Parking/Box
         */
        $category = new LodgingCategory();
        $category->setName('Parking/Box');
        $manager->persist($category);

        /*
         * Loft/Atelier
         */
        $category = new LodgingCategory();
        $category->setName('Loft/Atelier');
        $manager->persist($category);

        /*
         * Château
         */
        $category = new LodgingCategory();
        $category->setName('Château');
        $manager->persist($category);

        /*
         * HOTEL PARTICULIER
         */
        $category = new LodgingCategory();
        $category->setName('Hôtel particulier');
        $manager->persist($category);

        /*
         * BATIMENT
         */
        $category = new LodgingCategory();
        $category->setName('Bâtiment');
        $manager->persist($category);

        /*
         * Immeuble
         */
        $category = new LodgingCategory();
        $category->setName('Immeuble');
        $manager->persist($category);

        /*
         * COWORKING
         */
        $category = new LodgingCategory();
        $category->setName('Coworking');
        $manager->persist($category);

        /*
         * DIVERS
         */
        $category = new LodgingCategory();
        $category->setName('Divers');
        $manager->persist($category);


        $manager->flush();
    }
}
