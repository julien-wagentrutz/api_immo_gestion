<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Lodging;
use App\Entity\Tenant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TenantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tenant = new Tenant();
        $tenant->setName("Benoit");
        $tenant->setLastName('Hammon');
        $tenant->setBirthDate(new \DateTime('03-09-1997'));
        $tenant->setEmail('benoit.hammon@gmail.fr');
        $tenant->setPhoneNumber('0658959251');

        $account = $manager
            ->getRepository(Account::class)
            ->findOneBy(['state' => 'perso']);

        $tenant->addAccount($account);

        $user = $manager
            ->getRepository(User::class)
            ->findOneBy(['email' => 'julien.wgtz@outlook.com']);

        $tenant->setNameLastModifier($user);

        $lodging = $manager
            ->getRepository(Lodging::class)
            ->findOneBy(['name' => 'Appart 304']);

        $tenant->addLodgingCollection($lodging);

        $manager->persist($tenant);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LodgingFixtures::class,
        );
    }
}
