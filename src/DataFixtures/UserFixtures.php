<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
      private $encoder;

      public function __construct(UserPasswordEncoderInterface $encoder)
      {
            $this->encoder = $encoder;
      }

      public function load(ObjectManager $manager)
      {
            $faker = Factory::create('fr_FR');
            
            $user1 = new User();
            $user1->setLogin('admin')
                  ->setPassword($this->encoder->encodePassword($user1, 'admin'))
                  ->setRoles(['ROLE_ADMIN'])
                  ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName())
            ;
            $manager->persist($user1);

            $user2 = new User();
            $user2->setLogin('grh')
                  ->setPassword($this->encoder->encodePassword($user2, 'grh'))
                  ->setRoles(['ROLE_RH'])
                  ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName())
            ;
            $manager->persist($user2);

            $user3 = new User();
            $user3->setLogin('mons')
                  ->setPassword($this->encoder->encodePassword($user3, 'mons'))
                  ->setRoles(['ROLE_ANNUAIRE_MONS'])
                  ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName())
            ;
            $manager->persist($user3);

            $user4 = new User();
            $user4->setLogin('comptabilite')
                  ->setPassword($this->encoder->encodePassword($user4, 'comptabilite'))
                  ->setRoles(['ROLE_COMPTABILITE'])
                  ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName())
            ;
            $manager->persist($user4);
            
            $manager->flush();
      }
}