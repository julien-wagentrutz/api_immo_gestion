<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Collection;
use App\Entity\Lodging;
use App\Entity\LodgingCategory;
use App\Entity\LodgingType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LodgingFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $account = $manager
            ->getRepository(Account::class)
            ->findOneBy(['state' => 'perso']);

        $collection = new Collection();
        $collection->setName("Immeuble Saint Jean");
        $collection->setAccount($account);
        $manager->persist($collection);

        $lodging = new Lodging();
        $lodging->setName('Appart 304');
        $lodging->setState('Libre');
        $lodging->setCollection($collection);



        $lodging->setAccount($account);

        $category = $manager
            ->getRepository(LodgingCategory::class)
            ->findOneBy(['name' => 'Appartement']);

        $lodging->setLodgingCategory($category);

        $user = $manager
            ->getRepository(User::class)
            ->findOneBy(['email' => 'julien.wgtz@outlook.com']);
        $lodging->setNameLastModifier($user);

        $manager->persist($lodging);


        $lodging = new Lodging();
        $lodging->setName('Appart 304');
        $lodging->setState('Libre');
        $lodging->setCollection($collection);
        $lodging->setAccount($account);
        $lodging->setLodgingCategory($category);
        $lodging->setNameLastModifier($user);
        $manager->persist($lodging);


        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            AppFixtures::class,
        );
    }

}
