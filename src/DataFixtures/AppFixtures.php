<?php

namespace App\DataFixtures;

use App\Entity\Number;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Phonebook;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

      public function __construct(UserPasswordEncoderInterface $encoder)
      {
            $this->encoder = $encoder;
      }

      public function load(ObjectManager $manager)
      {
            $faker = Factory::create('fr_FR');

            /**
             * Phonebooks
             */
            $phonebook1 = new Phonebook();
            $phonebook1->setName('Caserne Mons')
                       ->setRolesManagement(['ROLE_ANNUAIRE_MONS'])
                       ->setRolesVisibility(['ROLE_RH','ROLE_COMPTABILITE'])
            ;
            $manager->persist($phonebook1);

            $phonebook2 = new Phonebook();
            $phonebook2->setName('Comptabilité')
                        ->setRolesManagement(['ROLE_COMPTABILITE'])
                        ->setRolesVisibility(['ROLE_USER'])
            ;
            $manager->persist($phonebook2);

            $phonebook3 = new Phonebook();
            $phonebook3->setName('RH')
                        ->setRolesManagement(['ROLE_RH'])
                        ->setRolesVisibility(['ROLE_RH'])
            ;
            $manager->persist($phonebook3);
            

            /**
             * Users
             */
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

             /**
             * Numbers
             */
            $number1 = new Number();
            $number1->setName('Caserne Mons')
                    ->setPhoneNumber('065/12.36.32')
                    ->setType('Professionnel')
                    ->addPhonebook($phonebook1)
                    ->setUser($user1)
            ;
            $manager->persist($number1);

            $number2 = new Number();
            $number2->setName('Secrétariat bis')
                    ->setPhoneNumber('066/42.36.32')
                    ->setType('Professionnel')
                    ->addPhonebook($phonebook1)
                    ->setUser($user2)
            ;
            $manager->persist($number2);

            $number3 = new Number();
            $number3->setName('Police')
                    ->setPhoneNumber('067/55.36.32')
                    ->setType('Professionnel')
                    ->addPhonebook($phonebook2)
                    ->setUser($user3)
            ;
            $manager->persist($number3);

            $number4 = new Number();
            $number4->setName('Ambulance')
                    ->setPhoneNumber('068/69.48.32')
                    ->setType('Professionnel')
                    ->addPhonebook($phonebook2)
                    ->addPhonebook($phonebook1)
                    ->setUser($user4)
            ;
            $manager->persist($number4);

            $number5 = new Number();
            $number5->setName($user1->getFirstName(). ' '. $user1->getLastName())
                    ->setType('Professionnel')
                    ->setPhoneNumber($faker->phoneNumber)
                    ->setUser($user1)
            ;
            $manager->persist($number5);
            
            $manager->flush();
      }
}
