<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Address;
use App\Entity\Lodging;
use App\Entity\Rent;
use App\Entity\Tenant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TenantFixtures extends Fixture implements DependentFixtureInterface
{
    public const TENANT_1 = 'tenant_1';
    public const TENANT_2 = 'tenant_2';
    public const TENANT_6 = 'tenant_6';
    public const TENANT_4 = 'tenant_4';

    private $tenant1;
    private $tenant2;
    private $tenant3;
    private $tenant4;
    private $tenant5;
    private $tenant6;

    public function getDependencies()
    {
        return array(
            LodgingFixtures::class,
        );

    }

    public function load(ObjectManager $manager)
    {
        $this->createTenant($manager);
        $this->createRent($manager);
        $manager->flush();

    }

    public function createTenant(ObjectManager $manager)
    {

        $mary = new User();
        $mary->setEmail("mary.burnett@gmail.com");
        $mary->setPassword('buburne');
        $mary->setName('Mary');
        $mary->setLastName('Burnet');

        $address2 = new Address();
        $address2->setCity('Brunstatt');
        $address2->setZipCode('68350');
        $address2->setAddress('19A rue de Flaxlanden');
        $mary->setAddress($address2);

        $beatrice = new User();
        $beatrice->setEmail("beatrice.reddin@gmail.com");
        $beatrice->setPassword('radin55');
        $beatrice->setName('Beatrice');
        $beatrice->setLastName('Reddin');

        $address3 = new Address();
        $address3->setCity('Brunstatt');
        $address3->setZipCode('68350');
        $address3->setAddress('19A rue de Flaxlanden');
        $beatrice->setAddress($address3);

        $betty = new User();
        $betty->setEmail("betty.damron@gmail.com");
        $betty->setPassword('BabyBetty69');
        $betty->setName('Betty');
        $betty->setLastName('Damron');

        $address3 = new Address();
        $address3->setCity('Brunstatt');
        $address3->setZipCode('68350');
        $address3->setAddress('19A rue de Flaxlanden');
        $beatrice->setAddress($address3);


        $melanie = new User();
        $melanie->setEmail("melanie.vasquez@gmail.com");
        $melanie->setPassword('vasqii44ffk');
        $melanie->setName('Melanie');
        $melanie->setLastName('Vasquez');

        $address3 = new Address();
        $address3->setCity('Brunstatt');
        $address3->setZipCode('68350');
        $address3->setAddress('19A rue de Flaxlanden');
        $beatrice->setAddress($address3);

        $tenant1 = new Tenant();
        $tenant1->setCreator($this->getReference(AppFixtures::USER_JULIEN));
        $tenant1->setLastModifier($this->getReference(AppFixtures::USER_ARNOLD));
        $tenant1->setAccount($this->getReference(AppFixtures::ACCOUNT_PRO));
        $tenant1->setName('Denis');
        $tenant1->setLastName('Skomel');
        $tenant1->setBirthDate(new \DateTime('03-09-1952'));
        $tenant1->setPhoneNumber('0659959251');
        $tenant1->setEmail('deninis.skoll@gmail.fr');
        $tenant1->setUser($betty);
        $manager->persist($tenant1);

        $tenant2 = new Tenant();
        $tenant2->setCreator($this->getReference(AppFixtures::USER_JULIEN));
        $tenant2->setLastModifier($this->getReference(AppFixtures::USER_JULIEN));
        $tenant2->setAccount($this->getReference(AppFixtures::ACCOUNT_PRO));
        $tenant2->setName('Cheri');
        $tenant2->setLastName('G. Collins');
        $tenant2->setBirthDate(new \DateTime('03-09-1952'));
        $tenant2->setPhoneNumber('0659959251');
        $tenant2->setEmail('cheriri.skoll@gmail.fr');
        $tenant2->setUser($melanie);
        $manager->persist($tenant2);

        $tenant3 = new Tenant();
        $tenant3->setCreator($this->getReference(AppFixtures::USER_ARNOLD));
        $tenant3->setLastModifier($this->getReference(AppFixtures::USER_ARNOLD));
        $tenant3->setAccount($this->getReference(AppFixtures::ACCOUNT_PRO));
        $tenant3->setName('Jeannine');
        $tenant3->setLastName('Patterson');
        $tenant3->setBirthDate(new \DateTime('03-09-1952'));
        $tenant3->setPhoneNumber('0659959251');
        $tenant3->setEmail('jeannine.skoll@gmail.fr');
        $manager->persist($tenant3);

        $tenant4 = new Tenant();
        $tenant4->setCreator($this->getReference(AppFixtures::USER_ANTOINE));
        $tenant4->setLastModifier($this->getReference(AppFixtures::USER_ANTOINE));
        $tenant4->setAccount($this->getReference(AppFixtures::ACCOUNT_FREE));
        $tenant4->setName('Joseph');
        $tenant4->setLastName('Myers');
        $tenant4->setBirthDate(new \DateTime('03-09-1952'));
        $tenant4->setPhoneNumber('0659959251');
        $tenant4->setEmail('joseph.skoll@gmail.fr');
        $tenant4->setUser($mary);
        $manager->persist($tenant4);

        $tenant5 = new Tenant();
        $tenant5->setCreator($this->getReference(AppFixtures::USER_MATHIEU));
        $tenant5->setLastModifier($this->getReference(AppFixtures::USER_MATHIEU));
        $tenant5->setAccount($this->getReference(AppFixtures::ACCOUNT_PERSO));
        $tenant5->setName('Stephen');
        $tenant5->setLastName('Peterson');
        $tenant5->setBirthDate(new \DateTime('03-09-1952'));
        $tenant5->setPhoneNumber('0659959251');
        $tenant5->setEmail('stephen.skoll@gmail.fr');
        $manager->persist($tenant5);

        $tenant6 = new Tenant();
        $tenant6->setCreator($this->getReference(AppFixtures::USER_MATHIEU));
        $tenant6->setLastModifier($this->getReference(AppFixtures::USER_MATHIEU));
        $tenant6->setAccount($this->getReference(AppFixtures::ACCOUNT_PERSO));
        $tenant6->setName('Monique');
        $tenant6->setLastName('Gaynor');
        $tenant6->setUser($beatrice);
        $tenant6->setBirthDate(new \DateTime('03-09-1952'));
        $tenant6->setPhoneNumber('0659959251');
        $tenant6->setEmail('Monique.skoll@gmail.fr');
        $manager->persist($tenant6);

        $this->tenant1 = $tenant1;
        $this->tenant2 = $tenant2;
        $this->tenant3 = $tenant3;
        $this->tenant4 = $tenant4;
        $this->tenant5 = $tenant5;
        $this->tenant6 = $tenant6;

        $this->addReference(self::TENANT_1, $tenant1);
        $this->addReference(self::TENANT_2, $tenant2);
        $this->addReference(self::TENANT_6, $tenant6);
        $this->addReference(self::TENANT_4, $tenant4);
    }

    public function createRent(ObjectManager $manager)
    {

        $rent1 = new Rent();
        $rent1->setTenant($this->tenant1);
        $rent1->setStartRental(new \DateTime('14-03-2018'));
        $rent1->setEndRental(new \DateTime('14-03-2020'));
        $rent1->setLodging($this->getReference(LodgingFixtures::LODGING_1));

        $rent2 = new Rent();
        $rent2->setTenant($this->tenant2);
        $rent2->setStartRental(new \DateTime('29-02-2015'));
        $rent2->setEndRental(new \DateTime('14-03-2018'));
        $rent2->setLodging($this->getReference(LodgingFixtures::LODGING_2));

        $rent3 = new Rent();
        $rent3->setTenant($this->tenant3);
        $rent3->setStartRental(new \DateTime('29-04-2004'));
        $rent3->setEndRental(new \DateTime('05-06-2019'));
        $rent3->setLodging($this->getReference(LodgingFixtures::LODGING_2));

        $rent4 = new Rent();
        $rent4->setTenant($this->tenant4);
        $rent4->setStartRental(new \DateTime('17-09-1992'));
        $rent4->setLodging($this->getReference(LodgingFixtures::LODGING_4));

        $rent5 = new Rent();
        $rent5->setTenant($this->tenant5);
        $rent5->setStartRental(new \DateTime('03-09-1997'));
        $rent5->setEndRental(new \DateTime('05-06-2019'));
        $rent5->setLodging($this->getReference(LodgingFixtures::LODGING_6));

        $rent6 = new Rent();
        $rent6->setTenant($this->tenant6);
        $rent6->setStartRental(new \DateTime());
        $rent6->setLodging($this->getReference(LodgingFixtures::LODGING_1));

        $manager->persist($rent1);
        $manager->persist($rent2);
        $manager->persist($rent3);
        $manager->persist($rent4);
        $manager->persist($rent5);
        $manager->persist($rent6);
    }
}
