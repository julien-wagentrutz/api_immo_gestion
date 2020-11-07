<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\LodgingCategory;
use App\Entity\LodgingType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;


class AppFixtures extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

public function load(ObjectManager $manager)
    {

        $account = new Account();
        $account->setState('perso');
        $manager->persist($account);

        $user = new User();
        $user->setEmail('julien.wgtz@outlook.com');
        $user->setPassword('Julien68');
        $user->setName('Julien');
        $user->setLastName('Wagentrutz');
        $user->addAccount($account);
        $user->setPassword(
            $this->passwordEncoder->encodePassword( $user, $user->getPassword() )
        );
        $user->setLastAccountSelected($account);
        $manager->persist($user);

        /**
         *  APPARTEMENT
         */

        $category = new LodgingCategory();
        $category->setName('Appartement');
        $manager->persist($category);

        $type = new LodgingType();
        $type->setName("T1");
        $type->addLodgingCategoryCollection($category);
        $manager->persist($type);


        $type = new LodgingType();
        $type->setName("T2");
        $type->addLodgingCategoryCollection($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("T3");
        $type->addLodgingCategoryCollection($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("T4");
        $type->addLodgingCategoryCollection($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("T5");
        $type->addLodgingCategoryCollection($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("Loft");
        $type->addLodgingCategoryCollection($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("Duplex");
        $type->addLodgingCategoryCollection($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("Triplex");
        $type->addLodgingCategoryCollection($category);
        $manager->persist($type);

        $type = new LodgingType();
        $type->setName("Sousplex");
        $type->addLodgingCategoryCollection($category);
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
