<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Address;
use App\Entity\Intervention;
use App\Entity\Lodging;
use App\Entity\Message;
use App\Entity\Rent;
use App\Entity\Tenant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InteractionTenantFixtures extends Fixture implements DependentFixtureInterface
{

    public function getDependencies()
    {
        return array(
            TenantFixtures::class,
        );

    }

    public function load(ObjectManager $manager)
    {
        $this->sendMessage($manager);
        $this->createIntervention($manager);
        $manager->flush();
    }

    public function sendMessage(ObjectManager $manager)
    {
        $message1 = new Message();
        $message1->setContent('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic');
        $message1->setSender($this->getReference(AppFixtures::USER_JULIEN));
        $message1->setRecipientUser($this->getReference(TenantFixtures::TENANT_1)->getUser());
        $manager->persist($message1);

        $message2 = new Message();
        $message2->setContent('but also the leap into electronic');
        $message2->setSender($this->getReference(AppFixtures::USER_ARNOLD));
        $message2->setRecipientGroup($this->getReference(LodgingFixtures::GROUP_1));
        $manager->persist($message2);

        $message3 = new Message();
        $message3->setContent('but also the leap into electronic');
        $message3->setSender($this->getReference(TenantFixtures::TENANT_6)->getUser());
        $message3->setRecipientUser($this->getReference(TenantFixtures::TENANT_2)->getUser());
        $manager->persist($message3);

        $message4 = new Message();
        $message4->setContent('Hello i\'m new her');
        $message4->setSender($this->getReference(TenantFixtures::TENANT_1)->getUser());
        $message4->setRecipientGroup( $this->getReference(LodgingFixtures::GROUP_2));
        $manager->persist($message4);
    }

    public function createIntervention(ObjectManager $manager)
    {
        $interventation = new Intervention();
        $interventation->setLodging($this->getReference(LodgingFixtures::LODGING_1));
        $interventation->setTenant($this->getReference(TenantFixtures::TENANT_1));
        $manager->persist($interventation);

        $interventation2 = new Intervention();
        $interventation2->setLodging($this->getReference(LodgingFixtures::LODGING_3));
        $interventation2->setTenant($this->getReference(TenantFixtures::TENANT_6));
        $manager->persist($interventation2);
    }
}
