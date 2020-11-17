<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Address;
use App\Entity\Invitation;
use App\Entity\LodgingCategory;
use App\Entity\LodgingType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;



class AppFixtures extends Fixture
{
    public const USER_JULIEN ='user_julien';
    public const USER_MATHIEU='user_mathieu';
    public const USER_ANTOINE='user_antoine';
    public const USER_ARNOLD='user_arnold';
    public const ACCOUNT_FREE='account_free';
    public const ACCOUNT_PERSO='account_perso';
    public const ACCOUNT_PRO='account_pro';


    private $passwordEncoder;
    private $julien;
    private $antoine;
    private $arnold;
    private $mathieu;
    private $address1;
    private $address2;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

     public function load(ObjectManager $manager)
     {
         $this->createUser($manager);
         $this->createAccount($manager);
         $manager->flush();
     }

     public function createUser(ObjectManager $manager)
     {
         $this->julien = new User();
         $this->julien->setEmail("julien.wgtz@outlook.com");
         $this->julien->setPassword('Julien68');
         $this->julien->setName("Julien");
         $this->julien->setLastName('Wagentrutz');

         $this->address1 = new Address();
         $this->address1->setCity('Montreuil');
         $this->address1->setZipCode('93100');
         $this->address1->setAddress('69b rue de la république');

         $this->julien->setAddress($this->address1);

         $manager->persist($this->julien);
         $this->addReference(self::USER_JULIEN, $this->julien);


         $this->mathieu = new User();
         $this->mathieu->setEmail("mathieu.frantz@gmail.com");
         $this->mathieu->setPassword('Frantzy652');
         $this->mathieu->setName("mathieu");
         $this->mathieu->setLastName('Frantz');

         $addressMathieu = new Address();
         $addressMathieu->setCity('Paris');
         $addressMathieu->setZipCode('75008');
         $addressMathieu->setAddress('55 Rue du Faubourg Saint-Honor');
         $addressMathieu->setAddressComplement('Élysée');

         $this->mathieu->setAddress($addressMathieu);

         $manager->persist($this->mathieu);
         $this->addReference(self::USER_MATHIEU, $this->mathieu);


         $this->antoine = new User();
         $this->antoine->setEmail("antoine.bourdelle@gmail.com");
         $this->antoine->setPassword('bourdelleElPaso33');
         $this->antoine->setName("Antoine");
         $this->antoine->setLastName('Bourdelle');

         $addressAntoine = new Address();
         $addressAntoine->setCity('Paris');
         $addressAntoine->setZipCode('75007');
         $addressAntoine->setAddress('5 Avenue Anatole');
         $addressAntoine->setAddressComplement('Dit tour Eiffel');

         $this->antoine->setAddress($addressAntoine);

         $manager->persist($this->antoine);
         $this->addReference(self::USER_ANTOINE, $this->antoine);


         $this->arnold = new User();
         $this->arnold->setEmail("arnold.schwarzenegger@gmail.com");
         $this->arnold->setPassword('Schwarzy68');
         $this->arnold->setName("Arnold");
         $this->arnold->setLastName('Schwarzenegger');

         $this->address2 = new Address();
         $this->address2->setCity('Brunstatt');
         $this->address2->setZipCode('68350');
         $this->address2->setAddress('19A rue de Flaxlanden');

         $this->arnold->setAddress($this->address2);

         $manager->persist($this->arnold);
         $this->addReference(self::USER_ARNOLD, $this->arnold);

     }

     public function createAccount(ObjectManager $manager)
     {
         $accountFree = new Account();
         $accountFree->setType('free');
         $accountFree->setCreator($this->antoine);
         $manager->persist($accountFree);
         $this->addReference(self::ACCOUNT_FREE, $accountFree);


         $accountPerso = new Account();
         $accountPerso->setType('perso');
         $accountPerso->setCreator($this->mathieu);
         $accountPerso->setAddress($this->address1);
         $manager->persist($accountPerso);
         $this->addReference(self::ACCOUNT_PERSO, $accountPerso);


         $accountPro = new Account();
         $accountPro->setType('pro');
         $accountPro->setCreator($this->julien);
         $invitation = new Invitation();
         $invitation->setUserSender($this->julien);
         $invitation->setUserRecipient($this->arnold);
         $invitation->setAccount($accountPro);
         $invitation->setAccept(1);
         $manager->persist($invitation);
         $accountPro->addInvitation($invitation);
         $accountPro->setAddress($this->address2);
         $manager->persist($accountPro);
         $this->addReference(self::ACCOUNT_PRO, $accountPro);

     }
}
