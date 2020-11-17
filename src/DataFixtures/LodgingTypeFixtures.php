<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Lodging;
use App\Entity\LodgingCategory;
use App\Entity\LodgingType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LodgingTypeFixtures extends Fixture implements DependentFixtureInterface
{

    public const TYPE_MAISON_STUDIO='type_maison_studio';
    public const TYPE_MAISON_F5='type_maison_f5';
    public const TYPE_APT_LOFT='type_apt_loft';
    public const TYPE_APT_F2='type_apt_f2';


    public function getDependencies()
    {
        return array(
            AppFixtures::class,
        );
    }

    public function load(ObjectManager $manager)
    {
        $maison = new LodgingCategory();
        $maison->setLabel('Maison');

        $appartement = new LodgingCategory();
        $appartement->setLabel('Appartement');

        $terrain = new LodgingCategory();
        $terrain->setLabel('Terrain');

        $parkingBox = new LodgingCategory();
        $parkingBox->setLabel('Parking/box');

        $loftAtelier = new LodgingCategory();
        $loftAtelier->setLabel('Loft/Atelier');

        $chateau = new LodgingCategory();
        $chateau->setLabel('Château');

        $hotelPartic = new LodgingCategory();
        $hotelPartic->setLabel('Hôtel particulier');

        $batiment = new LodgingCategory();
        $batiment->setLabel('Bâtiment');

        $immeuble = new LodgingCategory();
        $immeuble->setLabel('Immeuble');

        $coworking = new LodgingCategory();
        $coworking->setLabel('Coworking');

        $divers = new LodgingCategory();
        $divers->setLabel('Divers');

        $studio = new LodgingType();
        $studio->setLabel('Studio');
        $manager->persist($studio);

        $f2 = new LodgingType();
        $f2->setLabel('F2');
        $manager->persist($f2);

        $f3 = new LodgingType();
        $f3->setLabel('F3');
        $manager->persist($f3);

        $f4 = new LodgingType();
        $f4->setLabel('F4');
        $manager->persist($f4);

        $f5 = new LodgingType();
        $f5->setLabel('F5');
        $manager->persist($f5);

        $loft = new LodgingType();
        $loft->setLabel('Loft');
        $manager->persist($loft);

        $appartement->addLodgingType($studio);
        $appartement->addLodgingType($f2);
        $appartement->addLodgingType($f3);
        $appartement->addLodgingType($f4);
        $appartement->addLodgingType($f5);
        $appartement->addLodgingType($loft);

        $maison->addLodgingType($studio);
        $maison->addLodgingType($f2);
        $maison->addLodgingType($f3);
        $maison->addLodgingType($f4);
        $maison->addLodgingType($f5);
        $maison->addLodgingType($loft);

        $this->addReference(self::TYPE_APT_F2,$f2);
        $this->addReference(self::TYPE_APT_LOFT,$loft);
        $this->addReference(self::TYPE_MAISON_F5,$f5);
        $this->addReference(self::TYPE_MAISON_STUDIO,$studio);

        $manager->persist($divers);
        $manager->persist($coworking);
        $manager->persist($immeuble);
        $manager->persist($batiment);
        $manager->persist($hotelPartic);
        $manager->persist($chateau);
        $manager->persist($loftAtelier);
        $manager->persist($parkingBox);
        $manager->persist($terrain);
        $manager->persist($appartement);
        $manager->persist($maison);

        $manager->flush();
    }

}
