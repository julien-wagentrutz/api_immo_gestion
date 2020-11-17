<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Address;
use App\Entity\Group;
use App\Entity\GroupType;
use App\Entity\Lodging;
use App\Entity\LodgingCategory;
use App\Entity\LodgingType;
use App\Entity\State;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class LodgingFixtures extends Fixture implements DependentFixtureInterface
{
    public const LODGING_1 = 'lodging_1';
    public const LODGING_2 = 'lodging_2';
    public const LODGING_3 = 'lodging_3';
    public const LODGING_4 = 'lodging_4';
    public const LODGING_5 = 'lodging_5';
    public const LODGING_6 = 'lodging_6';
    public const GROUP_1 = 'GROUP_1';
    public const GROUP_2 = 'GROUP_2';

    private $accountFree;
    private $accountPerso;
    private $accountPro;
    private $manager;
    private $states;
    private $groups;
    private $users;
    private $address;
    private  $lodgingTypes;

    public function getDependencies()
    {
        return array(
            AppFixtures::class,
            LodgingTypeFixtures::class,
        );
    }

    public function __construct(EntityManagerInterface $manager)
    {

        $this->manager = $manager;

        $this->lodgingTypes =  $manager
            ->getRepository(LodgingType::class)
            ->findOneBy(['label' => 'Studio']);
    }

    public function load(ObjectManager $manager)
    {
        $this->createGroup();
        $this->createState();
        $this->createLoding();
        $manager->flush();
    }

    public function createGroup()
    {
        $coPropriete = new GroupType();
        $coPropriete->setLabel('Co-propriété');
        $this->manager->persist($coPropriete);
        $this->manager->persist($coPropriete);

        $residence = new GroupType();
        $residence->setLabel('Résidence');
        $this->manager->persist($residence);
        $this->manager->persist($residence);

        $immeuble = new GroupType();
        $immeuble->setLabel('Immeuble');
        $this->manager->persist($immeuble);
        $this->manager->persist($immeuble);

        $groupCoPro = new Group();
        $groupCoPro->setAccount($this->getReference(AppFixtures::ACCOUNT_PRO));
        $groupCoPro->setName('Les lilas');
        $groupCoPro->setGroupType($coPropriete);
        $this->manager->persist($groupCoPro);
        $this->groups['copro'] = $groupCoPro;

        $groupHypo = new Group();
        $groupHypo->setAccount($this->getReference(AppFixtures::ACCOUNT_PRO));
        $groupHypo->setName('Les eaux bleu');
        $groupHypo->setGroupType($immeuble);
        $this->manager->persist($groupHypo);
        $this->groups['hypo'] = $groupHypo;

        $groupResidence = new Group();
        $groupResidence->setName("Rodrigue");
        $groupResidence->setAccount($this->getReference(AppFixtures::ACCOUNT_PERSO));
        $groupResidence->setGroupType($residence);
        $this->manager->persist($groupResidence);
        $this->groups['residence'] = $groupResidence;

        $groupImmeuble = new Group();
        $groupImmeuble->setName("Immeuble Saint jean");
        $groupImmeuble->setAccount($this->getReference(AppFixtures::ACCOUNT_FREE));
        $groupImmeuble->setGroupType($immeuble);
        $this->manager->persist($groupImmeuble);
        $this->groups['immeuble'] = $groupImmeuble;

        $this->addReference(self::GROUP_1, $groupImmeuble);
        $this->addReference(self::GROUP_2, $groupCoPro);


    }

    public function createState()
    {
        $this->states['libre'] = new State();
        $this->states['libre']->setLabel('Libre');
        $this->manager->persist($this->states['libre']);

        $this->states['louer'] = new State();
        $this->states['louer']->setLabel('Louer');
        $this->manager->persist($this->states['louer']);

        $this->states['work'] = new State();
        $this->states['work']->setLabel('En travaux');
        $this->manager->persist($this->states['work']);

        $this->states['unpaid'] = new State();
        $this->states['unpaid']->setLabel("Impayé");
        $this->manager->persist($this->states['unpaid']);

    }

    public function createLoding()
    {
        $address = new Address();
        $address->setCity('Brunstatt');
        $address->setZipCode('68350');
        $address->setAddress('19A rue de Flaxlanden');

        $logement1 = new Lodging();
        $logement1->setName('Appartement 304');
        $logement1->setPrice(750);
        $logement1->setCreator($this->getReference(AppFixtures::USER_JULIEN));
        $logement1->setLastModifier($this->getReference(AppFixtures::USER_ARNOLD));
        $logement1->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_MAISON_STUDIO));
        $logement1->setState($this->states['louer']);
        $logement1->setGroupId($this->groups['immeuble']);
        $logement1->setAddress($address);
        $this->manager->persist($logement1);

        $address = new Address();
        $address->setCity('Brunstatt');
        $address->setZipCode('68350');
        $address->setAddress('19A rue de Flaxlanden');

        $logement2 = new Lodging();
        $logement2->setName('Appartement 305');
        $logement2->setPrice(755);
        $logement2->setCreator($this->getReference(AppFixtures::USER_ARNOLD));
        $logement2->setLastModifier($this->getReference(AppFixtures::USER_ARNOLD));
        $logement2->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_MAISON_STUDIO));
        $logement2->setState($this->states['libre']);
        $logement2->setGroupId($this->groups['immeuble']);
        $logement2->setAddress($address);
        $this->manager->persist($logement2);

        $address = new Address();
        $address->setCity('Brunstatt');
        $address->setZipCode('68350');
        $address->setAddress('19A rue de Flaxlanden');

        $logement3 = new Lodging();
        $logement3->setName('Maison Dupuis');
        $logement3->setPrice(1550);
        $logement3->setCreator($this->getReference(AppFixtures::USER_ARNOLD));
        $logement3->setLastModifier($this->getReference(AppFixtures::USER_ARNOLD));
        $logement3->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_MAISON_STUDIO));
        $logement3->setState($this->states['louer']);
        $logement3->setGroupId($this->groups['copro']);
        $logement3->setAddress($address);
        $this->manager->persist($logement3);

        $address = new Address();
        $address->setCity('Brunstatt');
        $address->setZipCode('68350');
        $address->setAddress('19A rue de Flaxlanden');

        $logement4 = new Lodging();
        $logement4->setName('Loft St Claire');
        $logement4->setPrice(1350);
        $logement4->setCreator($this->getReference(AppFixtures::USER_ARNOLD));
        $logement4->setLastModifier($this->getReference(AppFixtures::USER_JULIEN));
        $logement4->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_MAISON_STUDIO));
        $logement4->setState($this->states['louer']);
        $logement4->setGroupId($this->groups['immeuble']);
        $logement4->setAddress($address);
        $this->manager->persist($logement4);

        $address = new Address();
        $address->setCity('Brunstatt');
        $address->setZipCode('68350');
        $address->setAddress('19A rue de Flaxlanden');

        $logement5 = new Lodging();
        $logement5->setName('Appartement 014');
        $logement5->setPrice(475);
        $logement5->setCreator($this->getReference(AppFixtures::USER_MATHIEU));
        $logement5->setLastModifier($this->getReference(AppFixtures::USER_MATHIEU));
        $logement5->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_MAISON_STUDIO));
        $logement5->setState($this->states['unpaid']);
        $logement5->setGroupId($this->groups['residence']);
        $logement5->setAddress($address);
        $this->manager->persist($logement5);

        $address = new Address();
        $address->setCity('Brunstatt');
        $address->setZipCode('68350');
        $address->setAddress('19A rue de Flaxlanden');

        $logement6 = new Lodging();
        $logement6->setName('Atelier Poterie');
        $logement6->setPrice(930);
        $logement6->setCreator($this->getReference(AppFixtures::USER_ANTOINE));
        $logement6->setLastModifier($this->getReference(AppFixtures::USER_ANTOINE));
        $logement6->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_APT_F2));
        $logement6->setState($this->states['louer']);
        $logement6->setGroupId($this->groups['hypo']);
        $logement6->setAddress($address);
        $this->manager->persist($logement6);

        $address = new Address();
        $address->setCity('Brunstatt');
        $address->setZipCode('68350');
        $address->setAddress('19A rue de Flaxlanden');

        $logement7 = new Lodging();
        $logement7->setName('Apt N°4');
        $logement7->setPrice(350);
        $logement7->setCreator($this->getReference(AppFixtures::USER_MATHIEU));
        $logement7->setLastModifier($this->getReference(AppFixtures::USER_MATHIEU));
        $logement7->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_APT_LOFT));
        $logement7->setState($this->states['libre']);
        $logement7->setGroupId($this->groups['residence']);
        $logement7->setAddress($address);
        $this->manager->persist($logement7);

        $address = new Address();
        $address->setCity('Brunstatt');
        $address->setZipCode('68350');
        $address->setAddress('19A rue de Flaxlanden');

        $logement8 = new Lodging();
        $logement8->setName('Maison Wagner');
        $logement8->setPrice(1250);
        $logement8->setCreator($this->getReference(AppFixtures::USER_ANTOINE));
        $logement8->setLastModifier($this->getReference(AppFixtures::USER_ANTOINE));
        $logement8->setLodgingType($this->getReference(LodgingTypeFixtures::TYPE_MAISON_F5));
        $logement8->setState($this->states['work']);
        $logement8->setGroupId($this->groups['hypo']);
        $logement8->setAddress($address);
        $this->manager->persist($logement8);

        $this->addReference(self::LODGING_1, $logement1);
        $this->addReference(self::LODGING_2, $logement2);
        $this->addReference(self::LODGING_3, $logement3);
        $this->addReference(self::LODGING_4, $logement4);
        $this->addReference(self::LODGING_5, $logement5);
        $this->addReference(self::LODGING_6, $logement6);


    }

}
